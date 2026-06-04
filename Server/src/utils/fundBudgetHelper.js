const FundBudget = require("../models/fundBudgetModel");
const AssemblyIssue = require("../models/assemblyIssueModel");

/**
 * Normalizes approved_fund text to match the FundBudget labels.
 */
const normalizeApprovedFundName = (raw) => {
  if (!raw) return null;
  const t = raw.trim();
  if (t === "") return null;
  
  const lt = t.toLowerCase();
  
  if (/^MLA\s*FUND$/i.test(t)) {
    return "MLA FUND";
  }
  if (/MLA Swechanudan/i.test(t) || /MLA Sweechanudan/i.test(t)) {
    return "MLA Sweechanudan";
  }
  if (/^CLP\s/i.test(t)) {
    return "CLP Sweechanudan";
  }
  if (lt.includes("jansampark") && lt.includes("fund")) {
    return "Jansampark Fund";
  }
  if (/जन.*संपर्क/u.test(t) || /जन.*सम्पर्क/u.test(t)) {
    return "Jansampark Fund";
  }
  return null;
};

/**
 * Calculates total spent amount for a specific fund and year
 */
const sumSpentForFundYear = async (tenantId, normalizedFund, financialYear, excludeIssueId = null) => {
  // Map normalizedFund to a regex for matching existing records
  let fundRegex;
  if (normalizedFund === "MLA FUND") {
    fundRegex = /MLA\s*FUND/i;
  } else if (normalizedFund === "MLA Sweechanudan") {
    fundRegex = /MLA Swechanudan|MLA Sweechanudan/i;
  } else if (normalizedFund === "CLP Sweechanudan") {
    fundRegex = /^CLP\s/i;
  } else if (normalizedFund === "Jansampark Fund") {
    fundRegex = /jan.*sampark.*fund|जन.*संपर्क|जन.*सम्पर्क/i;
  } else {
    fundRegex = new RegExp(`^${normalizedFund}$`, "i");
  }

  // Financial Year matching logic (handles 'YYYY-YY', 'YYYY-YYYY', 'YYYY')
  const parts = financialYear.split("-");
  let yearMatches = [financialYear];
  if (parts.length === 2) {
    const startYear = parts[0];
    const finYearShort = `${startYear}-${parts[1].slice(-2)}`;
    yearMatches.push(startYear, finYearShort);
  } else if (parts.length === 1 && financialYear.length === 4) {
    const startYear = parseInt(financialYear);
    const finYearShort = `${startYear}-${(startYear + 1).toString().slice(-2)}`;
    yearMatches.push(finYearShort);
  }

  const query = {
    tenant: tenantId,
    approvedFund: { $regex: fundRegex },
    year: { $in: yearMatches },
    approximateCost: { $gt: 0 }
  };

  if (excludeIssueId) {
    query._id = { $ne: excludeIssueId };
  }

  // Aggregate sum of approximateCost
  const result = await AssemblyIssue.aggregate([
    { $match: query },
    { $group: { _id: null, totalSpent: { $sum: "$approximateCost" } } }
  ]);

  return result.length > 0 ? result[0].totalSpent : 0;
};

/**
 * Checks if adding the new amount exceeds the allocated budget
 */
const checkFundBudget = async (tenantId, approvedFund, financialYear, newAmount, excludeIssueId = null) => {
  if (!approvedFund || !financialYear || !newAmount || newAmount <= 0) {
    return { ok: true, message: "" };
  }

  const normalizedFund = normalizeApprovedFundName(approvedFund);
  if (!normalizedFund) {
    return { ok: true, message: "" }; // Not a tracked fund
  }

  // Find the budget limit
  const fundBudget = await FundBudget.findOne({
    tenant: tenantId,
    financialYear: financialYear,
    fundKey: normalizedFund
  });

  if (!fundBudget) {
    // If no budget is set, we don't block it (similar to legacy logic)
    return { ok: true, message: "" };
  }

  const limit = fundBudget.totalAmount;
  const spent = await sumSpentForFundYear(tenantId, normalizedFund, financialYear, excludeIssueId);
  const remaining = limit - spent;

  if (spent + newAmount > limit + 0.00001) {
    return {
      ok: false,
      message: `इस वित्तीय वर्ष के लिए कुल बजट ₹${limit.toLocaleString("en-IN")} है। पहले से उपयोग: ₹${spent.toLocaleString("en-IN")}। शेष धनराशि: ₹${remaining.toLocaleString("en-IN")}। नई राशि ₹${newAmount.toLocaleString("en-IN")} जोड़ने पर सीमा पार हो जाएगी। कृपया राशि कम करें या मास्टर में बजट बढ़ाएं।`,
      spent,
      limit,
      remaining
    };
  }

  return { ok: true, message: "", spent, limit };
};

module.exports = {
  normalizeApprovedFundName,
  sumSpentForFundYear,
  checkFundBudget
};
