const express = require("express");
const {
  getMembers,
  getMemberById,
  createMember,
  updateMember,
  deleteMember,
  bulkUploadMembers,
  downloadTemplate,
} = require("../controller/mpVidhanSabhaMemberController");
const protect = require("../middleware/authMiddleware");
const { checkPermission } = require("../middleware/permissionMiddleware");
const { scopeQuery } = require("../middleware/scopeMiddleware");
const { checkModuleAccess } = require("../middleware/moduleAccessMiddleware");
const multer = require("multer");

const upload = multer({ dest: "uploads/" });

const router = express.Router();

router.get("/template", protect, downloadTemplate);

router.post(
  "/bulk-upload",
  protect,
  checkModuleAccess("members"),
  checkPermission("create_members"),
  upload.single("bulk_file"),
  bulkUploadMembers
);

router
  .route("/")
  .get(
    protect,
    checkModuleAccess("members"),
    checkPermission("view_members"),
    scopeQuery(),
    getMembers,
  )
  .post(
    protect,
    checkModuleAccess("members"),
    checkPermission("create_members"),
    createMember,
  );

router
  .route("/:id")
  .get(
    protect,
    checkModuleAccess("members"),
    checkPermission("view_members"),
    scopeQuery(),
    getMemberById,
  )
  .put(
    protect,
    checkModuleAccess("members"),
    checkPermission("edit_members"),
    updateMember,
  )
  .delete(
    protect,
    checkModuleAccess("members"),
    checkPermission("delete_members"),
    deleteMember,
  );

module.exports = router;
