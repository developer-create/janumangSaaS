const asyncHandler = require("express-async-handler");
const Member = require("../models/mpVidhanSabhaMemberModel");
const { logActivity } = require("./activityLogController");
const { getCreateTenantId } = require("../utils/authHelpers");
const fs = require("fs");
const csv = require("csv-parser");

// @desc    Get members
// @route   GET /api/mp-vidhan-sabha-members
// @access  Private
exports.getMembers = asyncHandler(async (req, res) => {
  try {
    const {
      page = 1,
      limit,
      search,
      district,
      block,
      postYear,
      vehicle,
      samiti,
      code,
      } = req.query;

    const query = { ...req.scopeFilter };

    // Text Search
    if (search) {
      const escapedSearch = search.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
      query.$or = [
        { name: { $regex: escapedSearch, $options: "i" } },
        { voterId: { $regex: escapedSearch, $options: "i" } },
        { mobile: { $regex: escapedSearch, $options: "i" } },
        { fatherName: { $regex: escapedSearch, $options: "i" } },
        { district: { $regex: escapedSearch, $options: "i" } },
        { block: { $regex: escapedSearch, $options: "i" } },
        { samiti: { $regex: escapedSearch, $options: "i" } },
        { code: { $regex: escapedSearch, $options: "i" } },
        { grampanchayat: { $regex: escapedSearch, $options: "i" } },
        { village: { $regex: escapedSearch, $options: "i" } },
        { boothName: { $regex: escapedSearch, $options: "i" } },
      ];
    }

    // Filters
    if (district && district !== "all") query.district = district;
    if (block && block !== "all") query.block = block;
    if (postYear && postYear !== "all") query.postYear = postYear;
    if (vehicle && vehicle !== "all") query.vehicle = vehicle;
    if (samiti && samiti !== "all") query.samiti = samiti;
    if (code && code !== "all") query.code = code;
    const pageNum = parseInt(page) || 1;
    let limitNum = 10;
    if (limit !== undefined && limit !== null && limit !== "") {
      const parsedLimit = parseInt(limit);
      if (!isNaN(parsedLimit)) {
        limitNum = parsedLimit;
      }
    }

    let queryBuilder = Member.find(query)
      .populate("tenantId", "name")
      .sort({ createdAt: -1 })
      .allowDiskUse(true);

    if (limitNum !== -1) {
      const skip = (pageNum - 1) * limitNum;
      queryBuilder = queryBuilder.skip(skip).limit(limitNum);
    }

    const [members, total, count] = await Promise.all([
      queryBuilder,
      Member.countDocuments({ ...req.scopeFilter }),
      Member.countDocuments(query),
    ]);

    const formattedMembers = members.map((m) => {
      const obj = m.toObject();
      if (!obj.startDate) obj.startDate = obj.createdAt;
      if (!obj.endDate) obj.endDate = obj.createdAt;
      return obj;
    });

    res.json({
      success: true,
      data: formattedMembers,
      total,
      count,
      filteredCount: count,
      pagination: {
        page: pageNum,
        pages: limitNum === -1 ? 1 : Math.ceil(count / limitNum),
      },
    });
  } catch (error) {
    console.error("Error in getMembers:", error);
    res.status(500).json({
      success: false,
      message: "Failed to fetch members",
      error: error.message,
    });
  }
});

// @desc    Get member by ID
// @route   GET /api/mp-vidhan-sabha-members/:id
// @access  Private
exports.getMemberById = asyncHandler(async (req, res) => {
  const member = await Member.findOne({
    _id: req.params.id,
    ...req.scopeFilter,
  }).populate("tenantId", "name");

  if (!member) {
    res.status(404);
    throw new Error("Member not found");
  }

  res.json({ success: true, data: member });
});

// @desc    Create a member
// @route   POST /api/mp-vidhan-sabha-members
// @access  Private
exports.createMember = asyncHandler(async (req, res) => {
  const memberData = {
    ...req.body,
    addedBy: req.user ? req.user.name : "System",
    startDate: req.body.startDate || new Date(),
    endDate: req.body.endDate || new Date(),
    tenantId: getCreateTenantId(req), // SaaS: system admins create orphan records
  };

  const member = await Member.create(memberData);

  await logActivity(
    req,
    "CREATE",
    "Member",
    `Created member: ${member.name} (${member.code})`,
    { recordId: member._id, newData: member },
  );

  res.status(201).json({ success: true, data: member });
});

// @desc    Update member
// @route   PUT /api/mp-vidhan-sabha-members/:id
// @access  Private
exports.updateMember = asyncHandler(async (req, res) => {
  const member = await Member.findOne({
    _id: req.params.id,
    ...req.scopeFilter,
  });

  if (!member) {
    res.status(404);
    throw new Error("Member not found");
  }

  const oldData = member.toObject();

  // Update fields from body — EXCLUDE security-critical fields
  Object.keys(req.body).forEach((key) => {
    // Prevent hijacking the record to another tenant or spoofing IDs
    if (["tenantId", "_id", "__v"].includes(key)) return;

    if (req.body[key] !== undefined) {
      member[key] = req.body[key];
    }
  });

  const updatedMember = await member.save();

  await logActivity(
    req,
    "UPDATE",
    "Member",
    `Updated member: ${updatedMember.name} (${updatedMember.code})`,
    { recordId: updatedMember._id, newData: updatedMember, oldData },
  );

  res.json({ success: true, data: updatedMember });
});

// @desc    Delete member
// @route   DELETE /api/mp-vidhan-sabha-members/:id
// @access  Private
exports.deleteMember = asyncHandler(async (req, res) => {
  const member = await Member.findOne({
    _id: req.params.id,
    ...req.scopeFilter,
  });

  if (!member) {
    res.status(404);
    throw new Error("Member not found");
  }

  await member.deleteOne();

  await logActivity(req, "DELETE", "Member", `Deleted member: ${member.code}`, {
    recordId: member._id,
    oldData: member,
  });

  res.json({ success: true, message: "Member removed" });
});

// @desc    Download CSV Template
// @route   GET /api/mp-vidhan-sabha-members/template
// @access  Private
exports.downloadTemplate = asyncHandler(async (req, res) => {
  const headers = [
    "name", "mobile", "position", "district", "block", "panchayat", "village", "vidhansabha", "loksabha", "year", "month", "date", "remark", "voterId", "gender", "fatherName", "caste", "dob", "dom", "age", "education", "address", "vehicle", "group", "govtEmployee", "party", "code", "nariSammanYojna", "farmerLoanWaiver", "facebook", "instagram", "twitter", "reference", "boothName", "boothNumber", "grampanchayat", "toll", "janpadPanchayat", "mandalam", "jaati", "startLat", "startLong", "startDate", "endLat", "endLong", "endDate", "bg", "bc", "er", "br", "ip", "sc", "sa", "yc", "ap", "fp", "pp", "wc", "pa", "pc", "ak", "fm", "zp", "vp", "sr", "in_field", "eo", "gs", "us", "pw", "nl", "fr", "so", "st", "ob", "smw", "smtw", "it", "test", "dyc", "dcc", "obc", "cell_mp", "dt", "dp", "avp", "meet", "media", "mla_x_mla", "vech", "it_cell_exp", "info", "nsui", "imp", "advise", "ref"
  ];
  
  const dummyRows = [
    ["Ramesh Kumar", "9876543210", "President", "Bhopal", "Phanda", "Ratibad", "Ratibad", "Huzur", "Bhopal", "2024", "05", "2024-05-20", "Test 1", "ABC1234567", "Male", "Suresh Kumar", "OBC", "1990-01-01", "2015-05-15", "34", "B.A.", "123 Main St", "Bike", "Group A", "No", "BJP", "C123", "Yes", "No", "fb.com/ramesh", "inst", "twit", "Ref1", "Booth1", "101", "GramP1", "Toll1", "Janpad1", "Mandal1", "Jaati1", "23.2", "77.4", "2024-05-20", "23.3", "77.5", "2024-05-20", "1", "0", "1", ...Array(47).fill("")],
    ["Sita Devi", "9876543211", "Member", "Indore", "Mhow", "Kishanganj", "Kishanganj", "Mhow", "Indore", "2024", "05", "2024-05-21", "Test 2", "XYZ9876543", "Female", "Ram Prasad", "General", "1985-02-02", "2010-06-16", "39", "M.A.", "456 Side St", "Car", "Group B", "Yes", "INC", "C124", "Yes", "Yes", "", "", "", "", "Booth2", "102", "GramP2", "Toll2", "Janpad2", "Mandal2", "Jaati2", "0", "0", "", "0", "0", "", "", "1", "", ...Array(47).fill("")]
  ];

  const csvContent = [
    headers.join(","),
    ...dummyRows.map(row => row.join(","))
  ].join("\n") + "\n";

  res.setHeader("Content-Type", "text/csv");
  res.setHeader("Content-Disposition", "attachment; filename=Member_Upload_Template.csv");
  res.send(csvContent);
});

// @desc    Bulk Upload Members
// @route   POST /api/mp-vidhan-sabha-members/bulk-upload
// @access  Private
exports.bulkUploadMembers = asyncHandler(async (req, res) => {
  if (!req.file) {
    res.status(400);
    throw new Error("Please upload a CSV file");
  }

  const results = [];
  const errors = [];
  const tenantId = getCreateTenantId(req);
  fs.createReadStream(req.file.path)
    .pipe(csv())
    .on("data", (data) => {
      // Basic validation
      if (!data.name) {
        errors.push({ row: data, error: "Name is required" });
        return;
      }

      // Convert '1' or 'Yes' or 'true' to boolean for the flags
      const parseBool = (val) => {
        if (!val) return false;
        const s = String(val).toLowerCase().trim();
        return s === '1' || s === 'yes' || s === 'true';
      };

      const parsedRow = {
        tenantId,
        name: data.name?.trim(),
        mobile: data.mobile,
        position: data.position,
        district: data.district,
        block: data.block,
        panchayat: data.panchayat,
        village: data.village,
        vidhansabha: data.vidhansabha,
        loksabha: data.loksabha,
        year: data.year,
        month: data.month,
        date: data.date ? new Date(data.date) : undefined,
        remark: data.remark,
        voterId: data.voterId,
        gender: data.gender,
        fatherName: data.fatherName,
        caste: data.caste,
        
        // Extended Fields
        dob: data.dob ? new Date(data.dob) : undefined,
        dom: data.dom ? new Date(data.dom) : undefined,
        age: data.age ? Number(data.age) : 0,
        education: data.education,
        address: data.address,
        vehicle: data.vehicle,
        group: data.group,
        govtEmployee: data.govtEmployee,
        party: data.party,
        code: data.code,
        nariSammanYojna: data.nariSammanYojna,
        farmerLoanWaiver: data.farmerLoanWaiver,
        facebook: data.facebook,
        instagram: data.instagram,
        twitter: data.twitter,
        reference: data.reference,
        boothName: data.boothName,
        boothNumber: data.boothNumber,
        grampanchayat: data.grampanchayat,
        toll: data.toll,
        janpadPanchayat: data.janpadPanchayat,
        mandalam: data.mandalam,
        jaati: data.jaati,
        startLat: data.startLat ? Number(data.startLat) : 0,
        startLong: data.startLong ? Number(data.startLong) : 0,
        startDate: data.startDate ? new Date(data.startDate) : undefined,
        endLat: data.endLat ? Number(data.endLat) : 0,
        endLong: data.endLong ? Number(data.endLong) : 0,
        endDate: data.endDate ? new Date(data.endDate) : undefined,
        
        tenantId,
        addedBy: req.user ? req.user.name : "System",
        bg: parseBool(data.bg),
        bc: parseBool(data.bc),
        er: parseBool(data.er),
        br: parseBool(data.br),
        ip: parseBool(data.ip),
        sc: parseBool(data.sc),
        sa: parseBool(data.sa),
        yc: parseBool(data.yc),
        ap: parseBool(data.ap),
        fp: parseBool(data.fp),
        pp: parseBool(data.pp),
        wc: parseBool(data.wc),
        pa: parseBool(data.pa),
        pc: parseBool(data.pc),
        ak: parseBool(data.ak),
        fm: parseBool(data.fm),
        zp: parseBool(data.zp),
        vp: parseBool(data.vp),
        sr: parseBool(data.sr),
        in_field: parseBool(data.in_field),
        eo: parseBool(data.eo),
        gs: parseBool(data.gs),
        us: parseBool(data.us),
        pw: parseBool(data.pw),
        nl: parseBool(data.nl),
        fr: parseBool(data.fr),
        so: parseBool(data.so),
        st: parseBool(data.st),
        ob: parseBool(data.ob),
        smw: parseBool(data.smw),
        smtw: parseBool(data.smtw),
        it: parseBool(data.it),
        test: parseBool(data.test),
        dyc: parseBool(data.dyc),
        dcc: parseBool(data.dcc),
        obc: parseBool(data.obc),
        cell_mp: parseBool(data.cell_mp),
        dt: parseBool(data.dt),
        dp: parseBool(data.dp),
        avp: parseBool(data.avp),
        meet: parseBool(data.meet),
        media: parseBool(data.media),
        mla_x_mla: parseBool(data.mla_x_mla),
        vech: parseBool(data.vech),
        it_cell_exp: parseBool(data.it_cell_exp),
        info: parseBool(data.info),
        nsui: parseBool(data.nsui),
        imp: parseBool(data.imp),
        advise: parseBool(data.advise),
        ref: parseBool(data.ref)
      };

      results.push(parsedRow);
    })
    .on("end", async () => {
      try {
        if (results.length > 0) {
          await Member.insertMany(results);
          await logActivity(req, "CREATE", "Member", `Bulk uploaded ${results.length} members`);
        }
        
        if (req.file && fs.existsSync(req.file.path)) {
          fs.unlinkSync(req.file.path);
        }

        res.status(200).json({
          success: true,
          message: `Successfully uploaded ${results.length} members.`,
          errors: errors.length > 0 ? errors : undefined,
          insertedCount: results.length
        });
      } catch (error) {
        console.error("Bulk upload error:", error);
        res.status(500).json({
          success: false,
          message: "Database insertion failed",
          error: error.message
        });
      }
    });
});
