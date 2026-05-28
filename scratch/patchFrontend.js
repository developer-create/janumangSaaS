const fs = require('fs');
const path = require('path');

const viewsDir = 'C:/xampp/htdocs/JanUmangSaas/adminlte-3-react-main/src/views/mpVidhanSabhaMember';

// 1. mpVidhanSabhaMember/index.tsx
let indexFile = fs.readFileSync(path.join(viewsDir, 'index.tsx'), 'utf-8');
indexFile = indexFile.replace(/\/members/g, '/mp-vidhan-sabha-members');
indexFile = indexFile.replace(/\/member-list\/bulk-upload/g, '/mp-vidhan-sabha-member/bulk-upload');
indexFile = indexFile.replace(/\/member-list\/create/g, '/mp-vidhan-sabha-member/create');
indexFile = indexFile.replace(/memberType === "mp-vidhan-sabha" \? "MP Vidhan Sabha Member" : "Vidhan Sabha Member List"/g, '"MP Vidhan Sabha Member List"');
indexFile = indexFile.replace(/memberType === "mp-vidhan-sabha" \? "\/mp-vidhan-sabha-member\/create" : "\/member-list\/create"/g, '"/mp-vidhan-sabha-member/create"');
indexFile = indexFile.replace(/const bulkPath = memberType === "mp-vidhan-sabha"[\s\S]*?router\.push\(bulkPath\);/g, 'router.push("/mp-vidhan-sabha-member/bulk-upload");');
indexFile = indexFile.replace(/memberType,[\s]*\}/g, '}');
indexFile = indexFile.replace(/memberType: { memberType\?: "vidhan-sabha" \| "mp-vidhan-sabha" }/g, '');
indexFile = indexFile.replace(/const MemberListContent = \(\{ memberType = "vidhan-sabha" \}: \{ memberType\?: "vidhan-sabha" \| "mp-vidhan-sabha" \} \) => \{/g, 'const MemberListContent = () => {');
indexFile = indexFile.replace(/const MemberList = \(\{ memberType = "vidhan-sabha" \}: \{ memberType\?: "vidhan-sabha" \| "mp-vidhan-sabha" \}\) => \{/g, 'const MemberList = () => {');
indexFile = indexFile.replace(/<MemberListContent memberType=\{memberType\} \/>/g, '<MemberListContent />');
indexFile = indexFile.replace(/if \(memberType === "mp-vidhan-sabha"\) \{[\s\S]*?\}/g, '');
fs.writeFileSync(path.join(viewsDir, 'index.tsx'), indexFile, 'utf-8');

// 2. mpVidhanSabhaMember/BulkUpload.tsx
let bulkFile = fs.readFileSync(path.join(viewsDir, 'BulkUpload.tsx'), 'utf-8');
bulkFile = bulkFile.replace(/\/members\/bulk-upload\?memberType=\$\{memberType\}/g, '/mp-vidhan-sabha-members/bulk-upload');
bulkFile = bulkFile.replace(/\/members\/template/g, '/mp-vidhan-sabha-members/template');
bulkFile = bulkFile.replace(/const BulkUpload = \(\{ memberType = "vidhan-sabha" \}: \{ memberType\?: "vidhan-sabha" \| "mp-vidhan-sabha" \}\) => \{/g, 'const BulkUpload = () => {');
bulkFile = bulkFile.replace(/if \(memberType === "mp-vidhan-sabha"\) \{[\s\S]*?\} else \{[\s\S]*?\}/g, 'router.push("/mp-vidhan-sabha-member");');
bulkFile = bulkFile.replace(/title=\{memberType === "mp-vidhan-sabha" \? "Bulk Upload MP Vidhan Sabha Members" : "Bulk Upload Members"\}/g, 'title="Bulk Upload MP Vidhan Sabha Members"');
fs.writeFileSync(path.join(viewsDir, 'BulkUpload.tsx'), bulkFile, 'utf-8');

// 3. mpVidhanSabhaMember/MPVidhansabhaMemberForm.tsx
let formFile = fs.readFileSync(path.join(viewsDir, 'MPVidhansabhaMemberForm.tsx'), 'utf-8');
formFile = formFile.replace(/\/members/g, '/mp-vidhan-sabha-members');
formFile = formFile.replace(/memberType: "mp-vidhan-sabha",/g, ''); // no longer needed
fs.writeFileSync(path.join(viewsDir, 'MPVidhansabhaMemberForm.tsx'), formFile, 'utf-8');

// 4. memberList/index.tsx (revert memberType changes)
let oldIndex = fs.readFileSync('C:/xampp/htdocs/JanUmangSaas/adminlte-3-react-main/src/views/memberList/index.tsx', 'utf-8');
oldIndex = oldIndex.replace(/const bulkPath = memberType === "mp-vidhan-sabha"[\s\S]*?router\.push\(bulkPath\);/g, 'router.push("/member-list/bulk-upload");');
oldIndex = oldIndex.replace(/memberType === "mp-vidhan-sabha" \? "\/mp-vidhan-sabha-member\/create" : "\/member-list\/create"/g, '"/member-list/create"');
oldIndex = oldIndex.replace(/memberType,[\s]*\}/g, '}');
fs.writeFileSync('C:/xampp/htdocs/JanUmangSaas/adminlte-3-react-main/src/views/memberList/index.tsx', oldIndex, 'utf-8');

// 5. memberList/BulkUpload.tsx (revert)
let oldBulk = fs.readFileSync('C:/xampp/htdocs/JanUmangSaas/adminlte-3-react-main/src/views/memberList/BulkUpload.tsx', 'utf-8');
oldBulk = oldBulk.replace(/const BulkUpload = \(\{ memberType = "vidhan-sabha" \}: \{ memberType\?: "vidhan-sabha" \| "mp-vidhan-sabha" \}\) => \{/g, 'const BulkUpload = () => {');
oldBulk = oldBulk.replace(/\/members\/bulk-upload\?memberType=\$\{memberType\}/g, '/members/bulk-upload');
oldBulk = oldBulk.replace(/if \(memberType === "mp-vidhan-sabha"\) \{[\s\S]*?\} else \{[\s\S]*?\}/g, 'router.push("/member-list");');
oldBulk = oldBulk.replace(/title=\{memberType === "mp-vidhan-sabha" \? "Bulk Upload MP Vidhan Sabha Members" : "Bulk Upload Members"\}/g, 'title="Bulk Upload Members"');
fs.writeFileSync('C:/xampp/htdocs/JanUmangSaas/adminlte-3-react-main/src/views/memberList/BulkUpload.tsx', oldBulk, 'utf-8');

// 6. Update app routes
const appPage1 = 'C:/xampp/htdocs/JanUmangSaas/adminlte-3-react-main/src/app/(protected)/mp-vidhan-sabha-member/page.tsx';
let p1 = fs.readFileSync(appPage1, 'utf-8');
p1 = p1.replace(/@app\/views\/memberList/g, '@app/views/mpVidhanSabhaMember');
p1 = p1.replace(/memberType="mp-vidhan-sabha"/g, '');
fs.writeFileSync(appPage1, p1, 'utf-8');

const appPage2 = 'C:/xampp/htdocs/JanUmangSaas/adminlte-3-react-main/src/app/(protected)/mp-vidhan-sabha-member/bulk-upload/page.tsx';
let p2 = fs.readFileSync(appPage2, 'utf-8');
p2 = p2.replace(/@app\/views\/memberList\/BulkUpload/g, '@app/views/mpVidhanSabhaMember/BulkUpload');
p2 = p2.replace(/memberType="mp-vidhan-sabha"/g, '');
fs.writeFileSync(appPage2, p2, 'utf-8');

console.log("Frontend separated successfully.");
