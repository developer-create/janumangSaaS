const FundBudget = require("../models/fundBudgetModel");
const asyncHandler = require("express-async-handler");
const AppError = require("../utils/AppError");
const { getCreateTenantId } = require("../utils/authHelpers");

// Get all fund budgets
exports.getAllFundBudgets = asyncHandler(async (req, res, next) => {
  let query = { tenant: req.tenantId };

  if (req.query.financialYear) {
    query.financialYear = req.query.financialYear;
  }
  if (req.query.fundKey) {
    query.fundKey = req.query.fundKey;
  }

  // Pagination
  const page = parseInt(req.query.page, 10) || 1;
  const limit = req.query.limit === "-1" ? 0 : parseInt(req.query.limit, 10) || 10;
  const skip = (page - 1) * limit;

  let dbQuery = FundBudget.find(query).sort("-createdAt");

  if (limit > 0) {
    dbQuery = dbQuery.skip(skip).limit(limit);
  }

  const fundBudgets = await dbQuery.populate("createdBy", "name email");
  const total = await FundBudget.countDocuments(query);

  res.status(200).json({
    status: "success",
    results: fundBudgets.length,
    data: fundBudgets,
    total,
    page,
    limit: limit === 0 ? total : limit,
  });
});

// Get single fund budget
exports.getFundBudget = asyncHandler(async (req, res, next) => {
  const fundBudget = await FundBudget.findOne({
    _id: req.params.id,
    tenant: req.tenantId,
  });

  if (!fundBudget) {
    return next(new AppError("No fund budget found with that ID", 404));
  }

  res.status(200).json({
    status: "success",
    data: fundBudget,
  });
});

// Create fund budget
exports.createFundBudget = asyncHandler(async (req, res, next) => {
  const { financialYear, fundKey, totalAmount } = req.body;

  const tenantId = getCreateTenantId(req);

  // Check if it already exists
  const existing = await FundBudget.findOne({
    tenant: tenantId,
    financialYear,
    fundKey,
  });

  if (existing) {
    return next(
      new AppError(
        "A budget record for this Financial Year and Fund Type already exists. Please edit the existing record.",
        400
      )
    );
  }

  const newFundBudget = await FundBudget.create({
    financialYear,
    fundKey,
    totalAmount,
    tenant: tenantId,
    createdBy: req.user.id,
  });

  res.status(201).json({
    status: "success",
    data: newFundBudget,
  });
});

// Update fund budget
exports.updateFundBudget = asyncHandler(async (req, res, next) => {
  const { financialYear, fundKey, totalAmount } = req.body;

  // Check for duplicates if FY or fundKey changed
  if (financialYear || fundKey) {
    const budgetToUpdate = await FundBudget.findOne({
      _id: req.params.id,
      tenant: req.tenantId,
    });
    if (!budgetToUpdate) {
      return next(new AppError("No fund budget found with that ID", 404));
    }

    const checkFY = financialYear || budgetToUpdate.financialYear;
    const checkKey = fundKey || budgetToUpdate.fundKey;

    const existing = await FundBudget.findOne({
      tenant: req.tenantId,
      financialYear: checkFY,
      fundKey: checkKey,
      _id: { $ne: req.params.id },
    });

    if (existing) {
      return next(
        new AppError(
          "A budget record for this Financial Year and Fund Type already exists.",
          400
        )
      );
    }
  }

  const fundBudget = await FundBudget.findOneAndUpdate(
    { _id: req.params.id, tenant: req.tenantId },
    {
      ...req.body,
      updatedBy: req.user.id,
    },
    {
      new: true,
      runValidators: true,
    }
  );

  if (!fundBudget) {
    return next(new AppError("No fund budget found with that ID", 404));
  }

  res.status(200).json({
    status: "success",
    data: fundBudget,
  });
});

// Delete fund budget
exports.deleteFundBudget = asyncHandler(async (req, res, next) => {
  const fundBudget = await FundBudget.findOneAndDelete({
    _id: req.params.id,
    tenant: req.tenantId,
  });

  if (!fundBudget) {
    return next(new AppError("No fund budget found with that ID", 404));
  }

  res.status(204).json({
    status: "success",
    data: null,
  });
});
