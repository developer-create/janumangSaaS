const AssemblyIssue = require("../models/assemblyIssueModel");
const FundBudget = require("../models/fundBudgetModel");
const asyncHandler = require("express-async-handler");
const AppError = require("../utils/AppError");
const { getEffectiveTenantId } = require("../utils/authHelpers");

exports.getFundSummaryStats = asyncHandler(async (req, res, next) => {
  const { financialYear } = req.query;

  const fundKeys = [
    "MLA FUND",
    "MLA Sweechanudan",
    "CLP Sweechanudan",
    "Jansampark Fund",
  ];

  const tenantId = getEffectiveTenantId(req);

  // 1. Get Budgets
  let budgetQuery = { tenant: tenantId, fundKey: { $in: fundKeys } };
  if (financialYear) {
    budgetQuery.financialYear = financialYear;
  }
  const budgets = await FundBudget.find(budgetQuery);

  // Group budgets by fundKey
  const budgetMap = {};
  fundKeys.forEach((fk) => {
    budgetMap[fk] = 0;
  });

  budgets.forEach((b) => {
    // If multiple years are returned (no financialYear filter), we sum them up or
    // we just use what's returned. Typically they filter by year.
    budgetMap[b.fundKey] += b.totalAmount || 0;
  });

  let issueMatch = {};
  // Handle Financial Year Logic like PHP (e.g., "2026-2027" matches "2026", "2026-2027", "2026-27")
  if (financialYear && financialYear !== "all") {
    const parts = financialYear.split("-");
    if (parts.length === 2) {
      const startYear = parts[0];
      const shortYear = startYear + "-" + parts[1].slice(-2); // e.g. 2026-27
      issueMatch.year = { $in: [startYear, financialYear, shortYear] };
    } else {
      issueMatch.year = financialYear;
    }
  }

  // Define regexes for matching fund keys
  const mlaSweechaRegex = /MLA Sweechanudan|MLA Swechanudan/i;
  const clpRegex = /^CLP\s/i;
  const janSamparkRegex = /jan.*sampark.*fund|जन.*संपर्क|जन.*सम्पर्क/i;
  const mlaFundRegex = /MLA FUND/i;

  const matchStage = {
    tenantId: tenantId,
    $or: [
      { approvedFund: { $regex: mlaSweechaRegex } },
      { approvedFund: { $regex: clpRegex } },
      { approvedFund: { $regex: janSamparkRegex } },
      { approvedFund: { $regex: mlaFundRegex } }
    ],
    ...(issueMatch.year ? { year: issueMatch.year } : {})
  };

  const usedAggregation = await AssemblyIssue.aggregate([
    { $match: matchStage },
    {
      $unionWith: {
        coll: "publicproblems",
        pipeline: [
          { $match: matchStage }
        ]
      }
    },
    {
      $addFields: {
        normalizedFund: {
          $switch: {
            branches: [
              { case: { $regexMatch: { input: "$approvedFund", regex: mlaSweechaRegex } }, then: "MLA Sweechanudan" },
              { case: { $regexMatch: { input: "$approvedFund", regex: clpRegex } }, then: "CLP Sweechanudan" },
              { case: { $regexMatch: { input: "$approvedFund", regex: janSamparkRegex } }, then: "Jansampark Fund" },
              { case: { $regexMatch: { input: "$approvedFund", regex: mlaFundRegex } }, then: "MLA FUND" }
            ],
            default: "$approvedFund"
          }
        }
      }
    },
    {
      $group: {
        _id: "$normalizedFund",
        totalUsed: { $sum: "$approximateCost" },
      },
    },
  ]);

  const usedMap = {};
  fundKeys.forEach((fk) => {
    usedMap[fk] = 0;
  });

  usedAggregation.forEach((agg) => {
    if (usedMap[agg._id] !== undefined) {
      usedMap[agg._id] = agg.totalUsed;
    }
  });

  // 3. Construct Result
  const stats = fundKeys.map((fk) => {
    const total = budgetMap[fk];
    const used = usedMap[fk];
    const available = total - used;
    return {
      fundKey: fk,
      totalAmount: total,
      usedAmount: used,
      availableAmount: available,
    };
  });

  res.status(200).json({
    status: "success",
    data: stats,
  });
});

exports.getFundSummaryList = asyncHandler(async (req, res, next) => {
  const { page = 1, limit = 20, financialYear, approvedFund, approvedFundIn, uniqueId, status, startDate, endDate } = req.query;
  const tenantId = getEffectiveTenantId(req);
  
  let matchStage = { tenantId: tenantId };
  
  if (financialYear && financialYear !== "all") {
    const parts = financialYear.split("-");
    if (parts.length === 2) {
      const startYear = parts[0];
      const shortYear = startYear + "-" + parts[1].slice(-2);
      matchStage.year = { $in: [startYear, financialYear, shortYear] };
    } else {
      matchStage.year = financialYear;
    }
  }

  const mlaSweechaRegex = /MLA Sweechanudan|MLA Swechanudan/i;
  const clpRegex = /^CLP\s/i;
  const janSamparkRegex = /jan.*sampark.*fund|जन.*संपर्क|जन.*सम्पर्क/i;
  const mlaFundRegex = /MLA FUND/i;

  if (approvedFund && approvedFund !== "all") {
    if (mlaSweechaRegex.test(approvedFund)) matchStage.approvedFund = { $regex: mlaSweechaRegex };
    else if (clpRegex.test(approvedFund)) matchStage.approvedFund = { $regex: clpRegex };
    else if (janSamparkRegex.test(approvedFund)) matchStage.approvedFund = { $regex: janSamparkRegex };
    else if (mlaFundRegex.test(approvedFund)) matchStage.approvedFund = { $regex: mlaFundRegex };
    else matchStage.approvedFund = approvedFund;
  } else if (approvedFundIn) {
     matchStage.$or = [
        { approvedFund: { $regex: mlaSweechaRegex } },
        { approvedFund: { $regex: clpRegex } },
        { approvedFund: { $regex: janSamparkRegex } },
        { approvedFund: { $regex: mlaFundRegex } }
      ];
  }
  
  if (uniqueId) {
    matchStage.uniqueId = { $regex: uniqueId, $options: "i" };
  }
  if (status && status !== "all") {
    matchStage.status = status;
  }
  if (startDate || endDate) {
    matchStage.registrationDate = {};
    if (startDate) matchStage.registrationDate.$gte = startDate;
    if (endDate) matchStage.registrationDate.$lte = endDate;
  }

  const pageNum = parseInt(page);
  const limitNum = parseInt(limit) === -1 ? 100000 : parseInt(limit);
  const skip = (pageNum - 1) * limitNum;

  const pipeline = [
    { $match: matchStage },
    { $addFields: { source: "AssemblyIssue" } },
    {
      $unionWith: {
        coll: "publicproblems",
        pipeline: [
          { $match: matchStage },
          { $addFields: { source: "PublicProblem" } }
        ]
      }
    },
    { $sort: { createdAt: -1 } }
  ];

  const totalPipeline = [...pipeline, { $count: "total" }];
  const dataPipeline = [...pipeline, { $skip: skip }, { $limit: limitNum }];

  const [totalResult, dataResult] = await Promise.all([
    AssemblyIssue.aggregate(totalPipeline),
    AssemblyIssue.aggregate(dataPipeline)
  ]);

  const total = totalResult.length > 0 ? totalResult[0].total : 0;

  res.status(200).json({
    status: "success",
    total,
    page: pageNum,
    pages: Math.ceil(total / limitNum),
    data: dataResult,
  });
});
