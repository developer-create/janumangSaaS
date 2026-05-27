const asyncHandler = require("express-async-handler");
const { isGlobalAdmin } = require("../utils/authHelpers");

/**
 * Middleware to restrict database queries based on user's geographic assignment (level and scope).
 * This ensures a 'District Admin' can't see data from other districts, even if they hit the same API.
 */
const scopeQuery = (levelFieldMap = {}, geographic = true, includeGlobal = false) => {
  return (req, res, next) => {
    // Global Admins can see everything
    if (isGlobalAdmin(req.user)) {
      // If a global admin has selected a specific tenant, show only that tenant's data
      if (req.tenantId) {
        if (includeGlobal) {
          req.scopeFilter = { $or: [{ tenantId: req.tenantId }, { tenantId: null }, { tenantId: { $exists: false } }] };
        } else {
          req.scopeFilter = { tenantId: req.tenantId };
        }
      } else {
        // No specific tenant selected → show ALL data (no filter restriction)
        req.scopeFilter = {};
        req.isGlobalScope = true;
      }
      return next();
    }

    const { level } = req.user;

    // SaaS: Every user (except global admin) MUST have a tenantId
    const tenantId = req.tenantId || req.user?.tenantId;
    if (!tenantId) {
      res.status(403);
      return next(
        new Error(
          "Your account is not associated with any organisation. Please contact your administrator.",
        ),
      );
    }

    // Restrict all queries to the user's tenant
    if (includeGlobal) {
      req.scopeFilter = { $or: [{ tenantId }, { tenantId: null }, { tenantId: { $exists: false } }] };
    } else {
      req.scopeFilter = { tenantId };
    }

    // If geographic filtering is disabled, or it's a tenant admin, we stop here
    if (!geographic || level === "tenant_admin") {
      return next();
    }

    // Default field mapping for geographic scopes
    const fieldMap = {
      state: "state",
      division: "division",
      district: "district",
      assembly: "assembly",
      block: "block",
      panchayat: "panchayat",
      village: "village",
      booth: "booth",
      ...levelFieldMap,
    };

    const targetField = fieldMap[level];

    // If the user's level has a corresponding geographic field, add it to the filter
    if (targetField && req.user[level]) {
      // If $or was used, we need to apply geographic scoping using $and to maintain logic correctness
      if (includeGlobal) {
        req.scopeFilter = {
          $and: [
            req.scopeFilter,
            { [targetField]: req.user[level] }
          ]
        };
      } else {
        req.scopeFilter[targetField] = req.user[level];
      }
    }

    next();
  };
};

module.exports = { scopeQuery };
