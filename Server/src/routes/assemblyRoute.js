const express = require("express");
const {
  getAssemblies,
  getAssemblyById,
  createAssembly,
  updateAssembly,
  deleteAssembly,
} = require("../controller/assemblyController");
const protect = require("../middleware/authMiddleware");
const { checkPermission } = require("../middleware/permissionMiddleware");
const { scopeQuery } = require("../middleware/scopeMiddleware");

const router = express.Router();

// Assembly — tenant-isolated: scopeQuery({}, false, true) scopes by tenantId only,
// no geographic sub-scoping needed (assemblies are org-level data)
router
  .route("/")
  .get(
    protect,
    // checkPermission("view_assemblies"), // Allowed for all authenticated users to populate dropdowns
    scopeQuery({}, false, true),
    getAssemblies,
  )
  .post(
    protect,
    checkPermission("create_assemblies"),
    scopeQuery({}, false, true),
    createAssembly,
  );

router
  .route("/:id")
  .get(
    protect,
    // checkPermission("view_assemblies"), // Allowed for all authenticated users to populate dropdowns
    scopeQuery({}, false, true),
    getAssemblyById,
  )
  .put(
    protect,
    checkPermission("edit_assemblies"),
    scopeQuery({}, false, true),
    updateAssembly,
  )
  .delete(
    protect,
    checkPermission("delete_assemblies"),
    scopeQuery({}, false, true),
    deleteAssembly,
  );

module.exports = router;
