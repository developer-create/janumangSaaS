const express = require("express");
const {
  getBlocks,
  getBlockById,
  createBlock,
  updateBlock,
  deleteBlock,
} = require("../controller/blockController");
const protect = require("../middleware/authMiddleware");
const { checkPermission } = require("../middleware/permissionMiddleware");
const { scopeQuery } = require("../middleware/scopeMiddleware");

const router = express.Router();

// Block — tenant-isolated: scopeQuery({}, false, true) = tenant scope only, no geographic sub-scoping
router
  .route("/")
  .get(
    protect,
    checkPermission("view_blocks"),
    scopeQuery({}, false, true),
    getBlocks,
  )
  .post(
    protect,
    checkPermission("create_blocks"),
    scopeQuery({}, false, true),
    createBlock,
  );

router
  .route("/:id")
  .get(
    protect,
    checkPermission("view_blocks"),
    scopeQuery({}, false, true),
    getBlockById,
  )
  .put(
    protect,
    checkPermission("edit_blocks"),
    scopeQuery({}, false, true),
    updateBlock,
  )
  .delete(
    protect,
    checkPermission("delete_blocks"),
    scopeQuery({}, false, true),
    deleteBlock,
  );

module.exports = router;
