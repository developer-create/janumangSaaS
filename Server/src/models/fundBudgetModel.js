const mongoose = require("mongoose");

const fundBudgetSchema = new mongoose.Schema(
  {
    financialYear: {
      type: String,
      required: [true, "Financial Year is required"],
    },
    fundKey: {
      type: String,
      required: [true, "Fund Type is required"],
      enum: ["MLA FUND", "MLA Sweechanudan", "CLP Sweechanudan", "Jansampark Fund"],
    },
    totalAmount: {
      type: Number,
      required: [true, "Total Amount is required"],
      min: [0, "Total Amount cannot be negative"],
    },
    tenant: {
      type: mongoose.Schema.Types.ObjectId,
      ref: "Tenant",
    },
    createdBy: {
      type: mongoose.Schema.Types.ObjectId,
      ref: "User",
      required: true,
    },
    updatedBy: {
      type: mongoose.Schema.Types.ObjectId,
      ref: "User",
    },
    isActive: {
      type: Boolean,
      default: true,
    },
  },
  {
    timestamps: true,
  }
);

// Ensure uniqueness per financial year and fund key for a given tenant
fundBudgetSchema.index({ tenant: 1, financialYear: 1, fundKey: 1 }, { unique: true });

const FundBudget = mongoose.model("FundBudget", fundBudgetSchema);

module.exports = FundBudget;
