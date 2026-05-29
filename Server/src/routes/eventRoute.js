const express = require("express");
const {
  getEvents,
  getEventById,
  createEvent,
  updateEvent,
  deleteEvent,
  syncAllEvents,
  approveEvent,
  rejectEvent,
  getPendingEvents,
} = require("../controller/eventController");
const protect = require("../middleware/authMiddleware");
const { checkPermission } = require("../middleware/permissionMiddleware");
const { scopeQuery } = require("../middleware/scopeMiddleware");
const { checkModuleAccess } = require("../middleware/moduleAccessMiddleware");

const router = express.Router();

router.post(
  "/sync",
  protect,
  checkModuleAccess("events"),
  checkPermission("edit_events"),
  syncAllEvents,
);

router.get(
  "/pending",
  protect,
  checkModuleAccess("events"),
  checkPermission("edit_events"), // Using edit_events as a proxy for admin, but ideally it should check if user is admin
  getPendingEvents,
);

router.post(
  "/:id/approve",
  protect,
  checkModuleAccess("events"),
  checkPermission("edit_events"),
  approveEvent,
);

router.post(
  "/:id/reject",
  protect,
  checkModuleAccess("events"),
  checkPermission("edit_events"),
  rejectEvent,
);

router
  .route("/")
  .get(
    protect,
    checkModuleAccess("events"),
    checkPermission("view_events"),
    scopeQuery(),
    getEvents,
  )
  .post(
    protect,
    checkModuleAccess("events"),
    checkPermission("create_events"),
    createEvent,
  );

router
  .route("/:id")
  .get(
    protect,
    checkModuleAccess("events"),
    checkPermission("view_events"),
    scopeQuery(),
    getEventById,
  )
  .put(
    protect,
    checkModuleAccess("events"),
    checkPermission("edit_events"),
    updateEvent,
  )
  .delete(
    protect,
    checkModuleAccess("events"),
    checkPermission("delete_events"),
    deleteEvent,
  );

module.exports = router;
