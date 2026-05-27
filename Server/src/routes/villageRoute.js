const express = require("express");
const {
  getVillages,
  getVillageById,
  createVillage,
  updateVillage,
  deleteVillage,
} = require("../controller/villageController");
const protect = require("../middleware/authMiddleware");
const { checkPermission } = require("../middleware/permissionMiddleware");
const { scopeQuery } = require("../middleware/scopeMiddleware");

const router = express.Router();

// Village — tenant-isolated via scopeQuery({}, false, true)
router
  .route("/")
  .get(
    protect,
    checkPermission("view_villages"),
    scopeQuery({}, false, true),
    getVillages,
  )
  .post(
    protect,
    checkPermission("create_villages"),
    scopeQuery({}, false, true),
    createVillage,
  );

router
  .route("/:id")
  .get(
    protect,
    checkPermission("view_villages"),
    scopeQuery({}, false, true),
    getVillageById,
  )
  .put(
    protect,
    checkPermission("edit_villages"),
    scopeQuery({}, false, true),
    updateVillage,
  )
  .delete(
    protect,
    checkPermission("delete_villages"),
    scopeQuery({}, false, true),
    deleteVillage,
  );

module.exports = router;
