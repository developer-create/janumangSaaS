const mongoose = require("mongoose");

const samitiMemberSchema = mongoose.Schema(
  {
    groupId: {
      type: mongoose.Schema.Types.ObjectId,
      required: true,
      index: true,
      // Ref can't be strictly defined because it's dynamic, 
      // but we will manually populate or join if needed.
    },
    samitiType: { 
      type: String, 
      required: true,
      index: true
    },
    memberName: { 
      type: String, 
      required: true,
      trim: true
    },
    fatherName: { 
      type: String,
      trim: true,
      default: ""
    },
    age: { 
      type: Number,
      default: 0
    },
    position: { 
      type: String,
      trim: true,
      default: ""
    },
    mobileNumber: { 
      type: String,
      trim: true,
      default: ""
    },
    remark: { 
      type: String,
      trim: true,
      default: ""
    },
    addedBy: { 
      type: mongoose.Schema.Types.ObjectId, 
      ref: "User" 
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
  }
);

samitiMemberSchema.index({ groupId: 1, tenantId: 1 });

module.exports = mongoose.model("SamitiMember", samitiMemberSchema, "samiti_members");
