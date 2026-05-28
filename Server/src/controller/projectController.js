const asyncHandler = require("express-async-handler");
const Project = require("../models/projectModel");
const District = require("../models/districtModel");
const ProjectComment = require("../models/projectCommentModel");
const { logActivity } = require("./activityLogController");
const { getCreateTenantId } = require("../utils/authHelpers");

// @desc    Get all projects
// @route   GET /api/projects
exports.getProjects = asyncHandler(async (req, res) => {
  const { block, department, status, tenderStatus, estimateRange, search, page = 1, limit } = req.query;

  const query = { ...req.scopeFilter };

  if (block) query.block = block;
  if (department) query.department = department;
  if (status) query.status = status;
  if (tenderStatus) query.tenderStatus = tenderStatus;

  if (estimateRange) {
    if (estimateRange === "0-1") query.proposalEstimate = { $gte: 0, $lt: 10000000 };
    else if (estimateRange === "1-5") query.proposalEstimate = { $gte: 10000000, $lt: 50000000 };
    else if (estimateRange === "5-10") query.proposalEstimate = { $gte: 50000000, $lt: 100000000 };
    else if (estimateRange === "10 Above") query.proposalEstimate = { $gte: 100000000 };
  }

  if (search) {
    query.$or = [
      { workName: { $regex: search, $options: "i" } },
      { district: { $regex: search, $options: "i" } },
      { officerName: { $regex: search, $options: "i" } },
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

  let projects;
  let filteredCount;
  let totalCount = await Project.countDocuments({ ...req.scopeFilter });

  // If limit is -1, fetch all records
  if (limitNum === -1) {
    projects = await Project.find(query).sort({ createdAt: -1 });
    filteredCount = projects.length;
  } else {
    const skip = (pageNum - 1) * limitNum;
    projects = await Project.find(query)
      .sort({ createdAt: -1 })
      .skip(skip)
      .limit(limitNum);
    filteredCount = await Project.countDocuments(query);
  }

  // Fetch comments to attach the latest comment
  const projectIds = projects.map((p) => p._id);
  const comments = await ProjectComment.find({ projectId: { $in: projectIds } })
    .sort({ createdAt: -1 })
    .populate("createdBy", "name");

  const projectWithComments = projects.map((project) => {
    const projectComments = comments.filter(
      (c) => c.projectId.toString() === project._id.toString()
    );
    const pObj = project.toObject();
    if (projectComments.length > 0) {
      const last = projectComments[0];
      const date = new Date(last.createdAt).toLocaleString("en-IN", {
        day: "2-digit", month: "2-digit", year: "numeric", hour: "2-digit", minute: "2-digit"
      });
      pObj.lastComment = `${last.comment} (${date})`;
    } else {
      pObj.lastComment = "No comments";
    }
    return pObj;
  });

  res.json({
    success: true,
    data: projectWithComments,
    count: totalCount,
    filteredCount: filteredCount,
  });
});

// @desc    Get single project
// @route   GET /api/projects/:id
exports.getProjectById = asyncHandler(async (req, res) => {
  const project = await Project.findById(req.params.id);
  if (!project) {
    res.status(404);
    throw new Error("Project not found");
  }

  // Optimize: Lookup related IDs
  const related = {
    districtId: null,
    divisionId: null,
    stateId: null,
  };

  if (project.district) {
    const distDoc = await District.findOne({ name: project.district }).populate(
      {
        path: "division",
        populate: { path: "state" },
      },
    );
    if (distDoc) {
      related.districtId = distDoc._id;
      if (distDoc.division) {
        related.divisionId = distDoc.division._id;
        related.divisionName = distDoc.division.name;
        if (distDoc.division.state) {
          related.stateId = distDoc.division.state._id;
          related.stateName = distDoc.division.state.name;
        }
      }
    }
  }

  res.json({ success: true, data: { ...project.toObject(), related } });
});

// @desc    Create a project
// @route   POST /api/projects
exports.createProject = asyncHandler(async (req, res) => {
  const project = await Project.create({
    ...req.body,
    tenantId: getCreateTenantId(req), // SaaS: system admins create orphan records
  });

  await logActivity(
    req,
    "CREATE",
    "Project",
    `Created project: ${project.workName}`,
    { recordId: project._id, newData: project },
  );

  res.status(201).json({ success: true, data: project });
});

// @desc    Update a project
// @route   PUT /api/projects/:id
exports.updateProject = asyncHandler(async (req, res) => {
  const project = await Project.findById(req.params.id);
  if (!project) {
    res.status(404);
    throw new Error("Project not found");
  }
  const oldData = project.toObject();

  const updatedProject = await Project.findByIdAndUpdate(
    req.params.id,
    req.body,
    { new: true },
  );

  await logActivity(
    req,
    "UPDATE",
    "Project",
    `Updated project: ${updatedProject.workName}`,
    { recordId: updatedProject._id, newData: updatedProject, oldData },
  );

  res.json({ success: true, data: updatedProject });
});

// @desc    Delete a project
// @route   DELETE /api/projects/:id
exports.deleteProject = asyncHandler(async (req, res) => {
  const project = await Project.findById(req.params.id);
  if (!project) {
    res.status(404);
    throw new Error("Project not found");
  }
  await project.deleteOne();

  await logActivity(
    req,
    "DELETE",
    "Project",
    `Deleted project: ${project.workName}`,
    { recordId: project._id, oldData: project },
  );

  res.json({ success: true, message: "Project removed" });
});

// @desc    Seed projects
// @route   POST /api/projects/seed
exports.seedProjects = asyncHandler(async (req, res) => {
  await Project.deleteMany();
  const projects = Array.from({ length: 50 }).map((_, i) => ({
    district: i % 2 === 0 ? "Dhar" : "Indore",
    block: i % 3 === 0 ? "Bagh" : "Tanda",
    department: i % 2 === 0 ? "PWD" : "Education",
    workName: `Project Work ${i + 1} - Road Construction`,
    projectCost: (i + 1) * 100000,
    proposalEstimate: (i + 1) * 120000,
    tsNoDate: `TS-${100 + i}/2025`,
    asNoDate: `AS-${500 + i}/2025`,
    status: i % 4 === 0 ? "Completed" : "In Progress",
    officerName: `Officer ${String.fromCharCode(65 + (i % 26))}`,
    contactNumber: "9876543210",
    remarks: "Sample remark for project",
  }));

  await Project.insertMany(projects);
  res.json({ success: true, message: "Seeded 50 projects" });
});

// @desc    Get comments for a project
// @route   GET /api/projects/:id/comments
exports.getProjectComments = asyncHandler(async (req, res) => {
  const comments = await ProjectComment.find({ projectId: req.params.id })
    .populate("createdBy", "name")
    .sort({ createdAt: -1 });

  res.json({ success: true, data: comments });
});

// @desc    Add a comment to a project
// @route   POST /api/projects/:id/comments
exports.addProjectComment = asyncHandler(async (req, res) => {
  const { comment } = req.body;
  if (!comment) {
    res.status(400);
    throw new Error("Comment text is required");
  }

  const newComment = await ProjectComment.create({
    projectId: req.params.id,
    comment,
    createdBy: req.user._id,
    tenantId: getCreateTenantId(req),
  });

  const populatedComment = await ProjectComment.findById(newComment._id).populate("createdBy", "name");

  await logActivity(
    req,
    "CREATE",
    "Project Comment",
    `Added comment to project`,
    { recordId: req.params.id, newData: newComment },
  );

  res.status(201).json({ success: true, data: populatedComment });
});
