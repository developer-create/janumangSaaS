const fs = require('fs');

// 1. mpVidhanSabhaMemberModel.js
let mpModel = fs.readFileSync('C:/xampp/htdocs/JanUmangSaas/Server/src/models/mpVidhanSabhaMemberModel.js', 'utf-8');
mpModel = mpModel.replace('const memberSchema = mongoose.Schema(', 'const mpVidhanSabhaMemberSchema = mongoose.Schema(');
mpModel = mpModel.replace('module.exports = mongoose.model("Member", memberSchema);', 'module.exports = mongoose.model("MpVidhanSabhaMember", mpVidhanSabhaMemberSchema);');
mpModel = mpModel.replace(/memberType: {[^}]+},/s, ''); // Remove memberType logic
fs.writeFileSync('C:/xampp/htdocs/JanUmangSaas/Server/src/models/mpVidhanSabhaMemberModel.js', mpModel, 'utf-8');

// 2. mpVidhanSabhaMemberController.js
let mpCtrl = fs.readFileSync('C:/xampp/htdocs/JanUmangSaas/Server/src/controller/mpVidhanSabhaMemberController.js', 'utf-8');
mpCtrl = mpCtrl.replace('const Member = require("../models/memberModel");', 'const Member = require("../models/mpVidhanSabhaMemberModel");');
mpCtrl = mpCtrl.replace(/\/api\/members/g, '/api/mp-vidhan-sabha-members');
mpCtrl = mpCtrl.replace(/memberType,\s*}/, '}');
mpCtrl = mpCtrl.replace(/if \(memberType\) query.memberType = memberType;\s*/, '');
mpCtrl = mpCtrl.replace(/const memberType = req.query.memberType \|\| req.body.memberType \|\| "vidhan-sabha";\s*/, '');
mpCtrl = mpCtrl.replace(/memberType,\s*/g, '');
fs.writeFileSync('C:/xampp/htdocs/JanUmangSaas/Server/src/controller/mpVidhanSabhaMemberController.js', mpCtrl, 'utf-8');

// 3. mpVidhanSabhaMemberRoute.js
let mpRoute = fs.readFileSync('C:/xampp/htdocs/JanUmangSaas/Server/src/routes/mpVidhanSabhaMemberRoute.js', 'utf-8');
mpRoute = mpRoute.replace(/..\/controller\/memberController/g, '../controller/mpVidhanSabhaMemberController');
fs.writeFileSync('C:/xampp/htdocs/JanUmangSaas/Server/src/routes/mpVidhanSabhaMemberRoute.js', mpRoute, 'utf-8');

// 4. memberModel.js
let memberModel = fs.readFileSync('C:/xampp/htdocs/JanUmangSaas/Server/src/models/memberModel.js', 'utf-8');
memberModel = memberModel.replace(/memberType: {[\s\S]*?index: true,\s*},/s, '');
fs.writeFileSync('C:/xampp/htdocs/JanUmangSaas/Server/src/models/memberModel.js', memberModel, 'utf-8');

// 5. memberController.js
let mCtrl = fs.readFileSync('C:/xampp/htdocs/JanUmangSaas/Server/src/controller/memberController.js', 'utf-8');
mCtrl = mCtrl.replace(/memberType,\s*}/, '}');
mCtrl = mCtrl.replace(/if \(memberType\) query.memberType = memberType;\s*/, '');
mCtrl = mCtrl.replace(/const memberType = req.query.memberType \|\| req.body.memberType \|\| "vidhan-sabha";\s*/, '');
mCtrl = mCtrl.replace(/memberType,\s*/g, '');
fs.writeFileSync('C:/xampp/htdocs/JanUmangSaas/Server/src/controller/memberController.js', mCtrl, 'utf-8');

// 6. Mount route in app.js
let appJs = fs.readFileSync('C:/xampp/htdocs/JanUmangSaas/Server/src/app.js', 'utf-8');
if (!appJs.includes('mpVidhanSabhaMemberRoute')) {
  appJs = appJs.replace('const memberRoutes = require("./routes/memberRoute");', 'const memberRoutes = require("./routes/memberRoute");\nconst mpVidhanSabhaMemberRoutes = require("./routes/mpVidhanSabhaMemberRoute");');
  appJs = appJs.replace('app.use("/api/members", memberRoutes);', 'app.use("/api/members", memberRoutes);\napp.use("/api/mp-vidhan-sabha-members", mpVidhanSabhaMemberRoutes);');
  fs.writeFileSync('C:/xampp/htdocs/JanUmangSaas/Server/src/app.js', appJs, 'utf-8');
}

console.log("Backend separated successfully.");
