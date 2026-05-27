const express = require("express");
const {
  getPanchayats,
  getPanchayatById,
  createPanchayat,
  updatePanchayat,
  deletePanchayat,
} = require("../controller/panchayatController");
const protect = require("../middleware/authMiddleware");
const { checkPermission } = require("../middleware/permissionMiddleware");
const { scopeQuery } = require("../middleware/scopeMiddleware");

const router = express.Router();

// Panchayat — tenant-isolated via scopeQuery({}, false, true)
router
  .route("/")
  .get(
    protect,
    checkPermission("view_panchayats"),
    scopeQuery({}, false, true),
    getPanchayats,
  )
  .post(
    protect,
    checkPermission("create_panchayats"),
    scopeQuery({}, false, true),
    createPanchayat,
  );

router
  .route("/:id")
  .get(
    protect,
    checkPermission("view_panchayats"),
    scopeQuery({}, false, true),
    getPanchayatById,
  )
  .put(
    protect,
    checkPermission("edit_panchayats"),
    scopeQuery({}, false, true),
    updatePanchayat,
  )
  .delete(
    protect,
    checkPermission("delete_panchayats"),
    scopeQuery({}, false, true),
    deletePanchayat,
  );

module.exports = router;
