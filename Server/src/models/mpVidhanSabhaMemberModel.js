const mongoose = require("mongoose");

const mpVidhanSabhaMemberSchema = mongoose.Schema(
  {
    addedBy: {
      type: String,
      trim: true,
      default: "",
    },
    
    vidhansabha: {
      type: String,
      trim: true,
      default: "",
    },
    district: {
      type: String,
      trim: true,
      default: "",
    },
    samiti: {
      type: String,
      trim: true,
      default: "",
      index: true,
    },
    block: {
      type: String,
      trim: true,
      default: "",
      index: true,
    },
    boothName: {
      type: String,
      trim: true,
      default: "",
    },
    boothNumber: {
      type: String,
      trim: true,
      default: "",
    },
    grampanchayat: {
      type: String,
      trim: true,
      default: "",
    },
    village: {
      type: String,
      trim: true,
      default: "",
    },
    toll: {
      type: String,
      trim: true,
      default: "",
    },
    janpadPanchayat: {
      type: String,
      trim: true,
      default: "",
    },
    mandalam: {
      type: String,
      trim: true,
      default: "",
    },
    name: {
      type: String,
      required: [true, "Name is required"],
      trim: true,
    },
    fatherName: {
      type: String,
      trim: true,
      default: "",
    },
    jaati: {
      type: String,
      trim: true,
      default: "",
    },
    dob: {
      type: Date,
    },
    age: {
      type: Number,
      default: 0,
    },
    dom: {
      type: Date,
    },
    education: {
      type: String,
      trim: true,
      default: "",
    },
    mobile: {
      type: String,
      trim: true,
      default: "",
    },
    date: {
      type: Date,
    },
    month: {
      type: String,
      trim: true,
      default: "",
    },
    year: {
      type: String,
      trim: true,
      default: "",
    },
    lokSabha: {
      type: String,
      trim: true,
      default: "",
    },
    position: {
      type: String,
      trim: true,
      default: "",
    },
    voterId: {
      type: String,
      trim: true,
      default: "",
    },
    address: {
      type: String,
      trim: true,
      default: "",
    },
    gender: {
      type: String,
      trim: true,
      default: "",
    },
    group: {
      type: String,
      trim: true,
      default: "",
    },
    vehicle: {
      type: String,
      trim: true,
      default: "",
    },
    govtEmployee: {
      type: String,
      trim: true,
      default: "",
    },
    party: {
      type: String,
      trim: true,
      default: "",
    },
    postYear: {
      type: String,
      trim: true,
      default: "",
    },
    code: {
      type: String,
      trim: true,
      default: "",
      index: true,
    },
    nariSammanYojna: {
      type: String,
      trim: true,
      default: "",
    },
    farmerLoanWaiver: {
      type: String,
      trim: true,
      default: "",
    },
    facebook: {
      type: String,
      trim: true,
      default: "",
    },
    instagram: { type: String, default: "", trim: true },
    twitter: { type: String, default: "", trim: true },
    image: { type: String, default: "" }, // URL or Base64
    reference: { type: String, default: "", trim: true },
    remark: { type: String, default: "", trim: true },
    startLat: { type: Number, default: 0 },
    startLong: { type: Number, default: 0 },
    startDate: { type: Date },
    endLat: { type: Number, default: 0 },
    endLong: { type: Number, default: 0 },
    endDate: { type: Date },
    
    // Additional Code Boolean Flags
    bg: { type: Boolean, default: false },
    bc: { type: Boolean, default: false },
    er: { type: Boolean, default: false },
    br: { type: Boolean, default: false },
    ip: { type: Boolean, default: false },
    sc: { type: Boolean, default: false },
    sa: { type: Boolean, default: false },
    yc: { type: Boolean, default: false },
    ap: { type: Boolean, default: false },
    fp: { type: Boolean, default: false },
    pp: { type: Boolean, default: false },
    wc: { type: Boolean, default: false },
    pa: { type: Boolean, default: false },
    pc: { type: Boolean, default: false },
    ak: { type: Boolean, default: false },
    fm: { type: Boolean, default: false },
    zp: { type: Boolean, default: false },
    vp: { type: Boolean, default: false },
    sr: { type: Boolean, default: false },
    in_field: { type: Boolean, default: false },
    eo: { type: Boolean, default: false },
    gs: { type: Boolean, default: false },
    us: { type: Boolean, default: false },
    pw: { type: Boolean, default: false },
    nl: { type: Boolean, default: false },
    fr: { type: Boolean, default: false },
    so: { type: Boolean, default: false },
    st: { type: Boolean, default: false },
    ob: { type: Boolean, default: false },
    smw: { type: Boolean, default: false },
    smtw: { type: Boolean, default: false },
    it: { type: Boolean, default: false },
    test: { type: Boolean, default: false },
    dyc: { type: Boolean, default: false },
    dcc: { type: Boolean, default: false },
    obc: { type: Boolean, default: false },
    cell_mp: { type: Boolean, default: false },
    dt: { type: Boolean, default: false },
    dp: { type: Boolean, default: false },
    avp: { type: Boolean, default: false },
    meet: { type: Boolean, default: false },
    media: { type: Boolean, default: false },
    mla_x_mla: { type: Boolean, default: false },
    vech: { type: Boolean, default: false },
    it_cell_exp: { type: Boolean, default: false },
    info: { type: Boolean, default: false },
    nsui: { type: Boolean, default: false },
    imp: { type: Boolean, default: false },
    advise: { type: Boolean, default: false },
    ref_code: { type: Boolean, default: false },

    tenantId: {
      type: mongoose.Schema.Types.ObjectId,
      ref: "Tenant",
      index: true,
    },
  },
  {
    timestamps: true,
  },
);

mpVidhanSabhaMemberSchema.index({ createdAt: -1 });

module.exports = mongoose.model("MpVidhanSabhaMember", mpVidhanSabhaMemberSchema);
