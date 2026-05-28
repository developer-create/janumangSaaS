const express = require("express");
const router = express.Router();
const {
  createSamitiMember,
  getSamitiMembers,
  getSamitiMemberById,
  updateSamitiMember,
  deleteSamitiMember,
} = require("../controller/samitiMemberController");
const authMiddleware = require("../middleware/authMiddleware");

// We need samitiType and groupId for getting list and creating
// e.g. POST /api/samiti-members/ganesh-samiti/:groupId
// e.g. GET /api/samiti-members/ganesh-samiti/:groupId
router.post("/:samitiType/:groupId", authMiddleware, createSamitiMember);
router.get("/:samitiType/:groupId", authMiddleware, getSamitiMembers);

// For updating, getting single, deleting, we just need the member ID
// e.g. GET /api/samiti-members/:id
// e.g. PUT /api/samiti-members/:id
// e.g. DELETE /api/samiti-members/:id
router.get("/:id", authMiddleware, getSamitiMemberById);
router.put("/:id", authMiddleware, updateSamitiMember);
router.delete("/:id", authMiddleware, deleteSamitiMember);

module.exports = router;
