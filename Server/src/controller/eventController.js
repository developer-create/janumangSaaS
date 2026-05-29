const asyncHandler = require("express-async-handler");
const Event = require("../models/eventModel");
const EventNotification = require("../models/eventNotificationModel");
const User = require("../models/userModel");
const {
  createGoogleEvent,
  updateGoogleEvent,
  deleteGoogleEvent,
} = require("../services/googleCalendarService");
const { logActivity } = require("./activityLogController");

// @desc    Get all events
// @route   GET /api/events
// @access  Private
exports.getEvents = asyncHandler(async (req, res) => {
  const { month, search, startDate, endDate, page = 1, limit } = req.query;

  const query = { ...req.scopeFilter };
  
  // Check if user is admin
  const isAdmin = req.user?.role?.name === 'admin' || req.user?.role?.name === 'superadmin';
  
  // Block RBAC
  if (!isAdmin && req.user?.blockId) {
    const blockIds = typeof req.user.blockId === 'string' ? req.user.blockId.split(',') : [req.user.blockId];
    query.block = { $in: blockIds };
  }
  
  // Normal users only see approved events
  if (!isAdmin) {
    query.approvalStatus = 'approved';
  }

  if (month && month !== "All Months") {
    query.month = month;
  }

  if (startDate && endDate) {
    query.programDate = {
      $gte: new Date(startDate),
      $lte: new Date(endDate),
    };
  }

  if (search) {
    query.$or = [
      { uniqueId: { $regex: search, $options: "i" } },
      { district: { $regex: search, $options: "i" } },
      { eventType: { $regex: search, $options: "i" } },
      { eventDetails: { $regex: search, $options: "i" } },
    ];
  }

  const pageNum = parseInt(page) || 1;
  // Parse limit: if not provided or invalid, default to 10
  // If explicitly -1, keep it as -1 for "all" entries
  let limitNum = 10;
  if (limit !== undefined && limit !== null && limit !== "") {
    const parsedLimit = parseInt(limit);
    if (!isNaN(parsedLimit)) {
      limitNum = parsedLimit;
    }
  }

  let events;
  let filteredCount;
  let totalCount;

  totalCount = await Event.countDocuments({ ...req.scopeFilter });

  // If limit is -1, fetch all records
  if (limitNum === -1) {
    events = await Event.find(query).sort({ programDate: -1 });
    filteredCount = events.length;
  } else {
    const skip = (pageNum - 1) * limitNum;
    events = await Event.find(query)
      .sort({ programDate: -1 })
      .skip(skip)
      .limit(limitNum);
    filteredCount = await Event.countDocuments(query);
  }

  res.json({
    success: true,
    data: events,
    count: totalCount,
    filteredCount: filteredCount,
  });
});

// @desc    Get single event
// @route   GET /api/events/:id
// @access  Private
exports.getEventById = asyncHandler(async (req, res) => {
  const event = await Event.findById(req.params.id);
  if (!event) {
    res.status(404);
    throw new Error("Event not found");
  }
  res.json({ success: true, data: event });
});

// @desc    Create event
// @route   POST /api/events
// @access  Private
exports.createEvent = asyncHandler(async (req, res) => {
  try {
    // Remove empty uniqueId to allow auto-generation
    const eventData = { ...req.body };
    if (!eventData.uniqueId || eventData.uniqueId.trim() === "") {
      delete eventData.uniqueId;
    }

    // Add tenantId from context
    eventData.tenantId = req.tenantId;

    // Create in Local DB
    const isAdmin = req.user?.role?.name === 'admin' || req.user?.role?.name === 'superadmin';
    eventData.approvalStatus = isAdmin ? 'approved' : 'pending';
    
    const event = await Event.create(eventData);

    // If pending, notify admins
    if (!isAdmin) {
      const admins = await User.find({ 'role': { $exists: true } }).populate('role');
      const adminUsers = admins.filter(u => u.role?.name === 'admin' || u.role?.name === 'superadmin');
      
      const notifications = adminUsers.map(admin => ({
        eventId: event._id,
        userId: admin._id,
        tenantId: req.tenantId
      }));
      if (notifications.length > 0) {
        await EventNotification.insertMany(notifications);
      }
    } else {
      // Sync to Google Calendar only if approved (created by admin)
      try {
        const googleEventId = await createGoogleEvent(event);
        if (googleEventId) {
          event.googleEventId = googleEventId;
          await event.save();
        }
      } catch (syncError) {
        console.error("Failed to sync new event to Google Calendar:", syncError);
      }
    }

    await logActivity(
      req,
      "CREATE",
      "Event",
      `Created event: ${event.uniqueId} - ${event.eventType}`,
      { recordId: event._id, newData: event },
    );

    res.status(201).json({ success: true, data: event });
  } catch (error) {
    // Note: asyncHandler handles thrown errors, but here we want to catch specific Mongoose dup key error
    if (error.code === 11000) {
      res.status(400);
      throw new Error("Unique ID already exists");
    }
    throw error; // Let other errors bubble up to asyncHandler
  }
});

// @desc    Update event
// @route   PUT /api/events/:id
// @access  Private
exports.updateEvent = asyncHandler(async (req, res) => {
  try {
    const event = await Event.findById(req.params.id);
    if (!event) {
      res.status(404);
      throw new Error("Event not found");
    }
    const updatedEvent = await Event.findByIdAndUpdate(
      req.params.id,
      req.body,
      { new: true },
    );

    const oldData = event.toObject();

    // Sync to Google Calendar
    try {
      if (updatedEvent.googleEventId) {
        await updateGoogleEvent(updatedEvent.googleEventId, updatedEvent);
      } else {
        // If it was never synced, sync it now
        const googleEventId = await createGoogleEvent(updatedEvent);
        if (googleEventId) {
          updatedEvent.googleEventId = googleEventId;
          await updatedEvent.save();
        }
      }
    } catch (syncError) {
      console.error("Failed to update Google Calendar event:", syncError);
    }

    await logActivity(
      req,
      "UPDATE",
      "Event",
      `Updated event: ${updatedEvent.uniqueId} - ${updatedEvent.eventType}`,
      { recordId: updatedEvent._id, newData: updatedEvent, oldData },
    );

    res.json({ success: true, data: updatedEvent });
  } catch (error) {
    if (error.code === 11000) {
      res.status(400);
      throw new Error("Unique ID already exists");
    }
    throw error;
  }
});

// @desc    Delete event
// @route   DELETE /api/events/:id
// @access  Private
exports.deleteEvent = asyncHandler(async (req, res) => {
  const event = await Event.findById(req.params.id);
  if (!event) {
    res.status(404);
    throw new Error("Event not found");
  }
  const googleEventId = event.googleEventId;
  await event.deleteOne();

  // Remove from Google Calendar
  if (googleEventId) {
    try {
      await deleteGoogleEvent(googleEventId);
    } catch (syncError) {
      console.error("Failed to delete Google Calendar event:", syncError);
    }
  }

  await logActivity(
    req,
    "DELETE",
    "Event",
    `Deleted event: ${event.uniqueId}`,
    { recordId: event._id, oldData: event },
  );

  res.json({ success: true, message: "Event removed" });
});

// @desc    Sync all unsynced events to Google Calendar
// @route   POST /api/events/sync
// @access  Private
exports.syncAllEvents = asyncHandler(async (req, res) => {
  const events = await Event.find({ googleEventId: { $exists: false } });
  let syncCount = 0;

  for (const event of events) {
    const googleEventId = await createGoogleEvent(event);
    if (googleEventId) {
      event.googleEventId = googleEventId;
      await event.save();
      syncCount++;
    }
  }

  res.json({
    success: true,
    message: `Successfully synced ${syncCount} events to Google Calendar.`,
  });
});


// @desc    Approve event
// @route   POST /api/events/:id/approve
// @access  Private (Admin only)
exports.approveEvent = asyncHandler(async (req, res) => {
  const event = await Event.findById(req.params.id);
  if (!event) {
    res.status(404);
    throw new Error("Event not found");
  }

  if (event.approvalStatus !== 'pending') {
    res.status(400);
    throw new Error("Event is not pending approval");
  }

  event.approvalStatus = 'approved';
  event.approvedBy = req.user._id;
  await event.save();

  // Mark notifications as read
  await EventNotification.updateMany({ eventId: event._id }, { isRead: true });

  // Sync to Google Calendar
  try {
    const googleEventId = await createGoogleEvent(event);
    if (googleEventId) {
      event.googleEventId = googleEventId;
      await event.save();
    }
  } catch (syncError) {
    console.error("Failed to sync approved event to Google Calendar:", syncError);
  }

  await logActivity(
    req,
    "UPDATE",
    "Event",
    `Approved event: ${event.uniqueId}`,
    { recordId: event._id, newData: event }
  );

  res.json({ success: true, message: "Event approved successfully", data: event });
});

// @desc    Reject event
// @route   POST /api/events/:id/reject
// @access  Private (Admin only)
exports.rejectEvent = asyncHandler(async (req, res) => {
  const { reason } = req.body;
  const event = await Event.findById(req.params.id);
  if (!event) {
    res.status(404);
    throw new Error("Event not found");
  }

  if (event.approvalStatus !== 'pending') {
    res.status(400);
    throw new Error("Event is not pending approval");
  }

  event.approvalStatus = 'rejected';
  event.approvedBy = req.user._id;
  event.rejectionReason = reason;
  await event.save();

  // Mark notifications as read
  await EventNotification.updateMany({ eventId: event._id }, { isRead: true });

  await logActivity(
    req,
    "UPDATE",
    "Event",
    `Rejected event: ${event.uniqueId}`,
    { recordId: event._id, newData: event }
  );

  res.json({ success: true, message: "Event rejected successfully", data: event });
});

// @desc    Get pending events
// @route   GET /api/events/pending
// @access  Private (Admin only)
exports.getPendingEvents = asyncHandler(async (req, res) => {
  const query = { ...req.scopeFilter, approvalStatus: 'pending' };
  const events = await Event.find(query).sort({ programDate: -1 });
  res.json({ success: true, data: events, count: events.length });
});
