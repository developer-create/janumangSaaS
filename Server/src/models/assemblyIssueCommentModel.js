const mongoose = require("mongoose");

const assemblyIssueCommentSchema = new mongoose.Schema(
  {
    issueId: {
      type: mongoose.Schema.Types.ObjectId,
      ref: "AssemblyIssue",
      required: true,
      index: true,
    },
    comment: {
      type: String,
      required: [true, "Comment text is required"],
    },
    status: {
      type: String,
      required: true,
      default: "Pending",
    },
    stage: {
      type: String,
      default: "assembly-issue",
    },
    fileUrl: {
      type: String,
    },
    fileName: {
      type: String,
    },
    createdBy: {
      type: mongoose.Schema.Types.ObjectId,
      ref: "User",
    },
    addedBy: {
      type: String, // Storing name or email for quick display
    },
    tenantId: {
      type: mongoose.Schema.Types.ObjectId,
      ref: "Tenant",
    },
  },
  {
    timestamps: true,
  }
);

module.exports = mongoose.model("AssemblyIssueComment", assemblyIssueCommentSchema);
