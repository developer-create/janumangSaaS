const SamitiMember = require("../models/samitiMemberModel");
const getSamitiModel = require("../models/samitiModel");

const updateParentSamitiCount = async (groupId, samitiType, tenantId) => {
  try {
    const SamitiModel = getSamitiModel(samitiType);
    const count = await SamitiMember.countDocuments({ groupId, tenantId });
    await SamitiModel.findByIdAndUpdate(groupId, { totalMembers: count.toString() });
  } catch (error) {
    console.error("Error updating parent samiti count:", error);
  }
};

const createSamitiMember = async (req, res) => {
  try {
    const { samitiType, groupId } = req.params;
    const { memberName, fatherName, age, position, mobileNumber, remark } = req.body;
    
    const newMember = new SamitiMember({
      groupId,
      samitiType,
      memberName,
      fatherName,
      age: age || 0,
      position,
      mobileNumber,
      remark,
      addedBy: req.user._id,
      tenantId: req.user.tenantId,
    });

    await newMember.save();
    
    // Update count
    await updateParentSamitiCount(groupId, samitiType, req.user.tenantId);

    res.status(201).json({
      success: true,
      data: newMember,
      message: "Member created successfully",
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
};

const getSamitiMembers = async (req, res) => {
  try {
    const { samitiType, groupId } = req.params;
    const { page = 1, limit = 10, search } = req.query;

    const query = {
      groupId,
      tenantId: req.user.tenantId,
    };

    if (search) {
      query.memberName = { $regex: search, $options: "i" };
    }

    const pageNum = parseInt(page);
    const limitNum = parseInt(limit);

    if (limitNum === -1) {
      const members = await SamitiMember.find(query).sort({ createdAt: -1 });
      return res.status(200).json({
        success: true,
        data: members,
        total: members.length,
      });
    }

    const total = await SamitiMember.countDocuments(query);
    const members = await SamitiMember.find(query)
      .sort({ createdAt: -1 })
      .skip((pageNum - 1) * limitNum)
      .limit(limitNum);

    res.status(200).json({
      success: true,
      data: members,
      total,
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
};

const getSamitiMemberById = async (req, res) => {
  try {
    const { id } = req.params;
    const member = await SamitiMember.findOne({
      _id: id,
      tenantId: req.user.tenantId,
    });

    if (!member) {
      return res.status(404).json({ success: false, message: "Member not found" });
    }

    res.status(200).json({ success: true, data: member });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
};

const updateSamitiMember = async (req, res) => {
  try {
    const { id } = req.params;
    
    const member = await SamitiMember.findOneAndUpdate(
      { _id: id, tenantId: req.user.tenantId },
      req.body,
      { new: true }
    );

    if (!member) {
      return res.status(404).json({ success: false, message: "Member not found" });
    }

    res.status(200).json({
      success: true,
      data: member,
      message: "Member updated successfully",
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
};

const deleteSamitiMember = async (req, res) => {
  try {
    const { id } = req.params;
    
    const member = await SamitiMember.findOneAndDelete({
      _id: id,
      tenantId: req.user.tenantId,
    });

    if (!member) {
      return res.status(404).json({ success: false, message: "Member not found" });
    }

    // Update count
    await updateParentSamitiCount(member.groupId, member.samitiType, req.user.tenantId);

    res.status(200).json({
      success: true,
      message: "Member deleted successfully",
    });
  } catch (error) {
    res.status(500).json({ success: false, message: error.message });
  }
};

module.exports = {
  createSamitiMember,
  getSamitiMembers,
  getSamitiMemberById,
  updateSamitiMember,
  deleteSamitiMember,
};
