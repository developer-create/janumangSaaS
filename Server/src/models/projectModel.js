const mongoose = require("mongoose");

const projectSchema = mongoose.Schema(
  {
    uniqueId: {
      type: String,
      index: true,
      default: null,
    },
    district: {
      type: String, // Ideally ObjectId if possible, but adhering to existing pattern as String
      required: [true, "District is required"],
      trim: true,
      index: true,
    },
    block: {
      type: String,
      required: [true, "Block is required"],
      trim: true,
      index: true,
    },
    department: {
      type: String,
      required: [true, "Department is required"],
      trim: true,
      index: true,
    },
    workName: {
      type: String,
      required: [true, "Work Name is required"],
      trim: true,
      index: true,
    },
    projectCost: {
      type: Number,
      required: [true, "Project Cost is required"],
      default: 0,
    },
    proposalEstimate: {
      type: Number,
      required: [true, "Proposal Estimate is required"],
      default: 0,
    },
    tsNoDate: {
      type: String,
      default: "",
      trim: true,
    },
    asNoDate: {
      type: String,
      default: "",
      trim: true,
    },
    status: {
      type: String,
      enum: ["Pending", "In Progress", "Completed"],
      default: "Pending",
      index: true,
    },
    officerName: {
      type: String,
      default: "",
      trim: true,
    },
    contactNumber: {
      type: String,
      default: "",
      trim: true,
    },
    technicalSession: {
      type: String,
      default: "",
      trim: true,
    },
    administrativeSession: {
      type: String,
      default: "",
      trim: true,
    },
    tenderStatus: {
      type: String,
      default: "",
      trim: true,
    },
    companyName: {
      type: String,
      default: "",
      trim: true,
    },
    contractorName: {
      type: String,
      default: "",
      trim: true,
    },
    phoneNo: {
      type: String,
      default: "",
      trim: true,
    },
    usdRemark: {
      type: String,
      default: "",
      trim: true,
    },
    remarks: {
      type: String,
      default: "",
      trim: true,
    },
    currentProgress: {
      type: String,
      default: "",
      trim: true,
    },
    tenantId: {
      type: mongoose.Schema.Types.ObjectId,
      ref: "Tenant",
      index: true,
      default: null,
    },
  },
  {
    timestamps: true,
  },
);

// Pre-save hook to generate uniqueId like "PS/001"
projectSchema.pre('save', async function() {
  if (this.isNew && !this.uniqueId) {
    const ProjectModel = mongoose.model('Project');
    const lastProject = await ProjectModel.findOne(
      { uniqueId: { $ne: null } },
      { uniqueId: 1 }
    ).sort({ createdAt: -1 });

    let nextNum = 1;
    if (lastProject && lastProject.uniqueId) {
      // Assuming format PS/001
      const parts = lastProject.uniqueId.split('/');
      if (parts.length === 2 && !isNaN(parseInt(parts[1], 10))) {
        nextNum = parseInt(parts[1], 10) + 1;
      } else {
        // Fallback if parsing fails, just count
        const count = await ProjectModel.countDocuments({ uniqueId: { $ne: null } });
        nextNum = count + 1;
      }
    }

    this.uniqueId = `PS/${String(nextNum).padStart(3, '0')}`;
  }
});

module.exports = mongoose.model("Project", projectSchema);
