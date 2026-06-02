const fs = require('fs');
const path = require('path');

const baseDir = 'C:/xampp/htdocs/JanUmangSaas/adminlte-3-react-main/src/views/memberList';

const createMemberPath = path.join(baseDir, 'CreateMember.tsx');
const editMemberPath = path.join(baseDir, 'EditMember.tsx');
const viewMemberPath = path.join(baseDir, 'ViewMember.tsx');
const schemaPath = path.join(baseDir, 'member.schema.ts');

function removeAdditionalCodes(filePath) {
    if (!fs.existsSync(filePath)) return;
    let content = fs.readFileSync(filePath, 'utf8');

    // Remove the block
    const regex = /\{\/\* Additional Codes \/ Flags.*?\}\)\)}[\s\S]*?<\/div>[\s\S]*?<\/div>/m;
    
    // For Create and Edit it might be slightly different. Let's find the exact boundaries.
    const startStr = "{/* Additional Codes / Flags";
    const startIndex = content.indexOf(startStr);
    
    if (startIndex !== -1) {
        // Find the Nari Samman block to know where it ends
        const bottomSectionStr = "{/* Bottom Section";
        const endIndex = content.indexOf(bottomSectionStr, startIndex);
        if (endIndex !== -1) {
            content = content.substring(0, startIndex) + content.substring(endIndex);
            fs.writeFileSync(filePath, content, 'utf8');
            console.log("Patched Additional Codes in: " + filePath);
        } else {
            console.log("Could not find bottom section in " + filePath);
        }
    } else {
        console.log("Could not find Additional Codes block in " + filePath);
    }
}

function removeAdditionalCodesFromView(filePath) {
    if (!fs.existsSync(filePath)) return;
    let content = fs.readFileSync(filePath, 'utf8');

    // In ViewMember it might look like:
    const startStr = "{/* Additional Codes / Flags";
    const startIndex = content.indexOf(startStr);
    
    if (startIndex !== -1) {
        const bottomSectionStr = "{/* Bottom Section";
        const endIndex = content.indexOf(bottomSectionStr, startIndex);
        if (endIndex !== -1) {
            content = content.substring(0, startIndex) + content.substring(endIndex);
            fs.writeFileSync(filePath, content, 'utf8');
            console.log("Patched Additional Codes in View: " + filePath);
        } else {
            console.log("Could not find bottom section in View: " + filePath);
        }
    } else {
        console.log("Could not find Additional Codes block in View: " + filePath);
    }
}

removeAdditionalCodes(createMemberPath);
removeAdditionalCodes(editMemberPath);
removeAdditionalCodesFromView(viewMemberPath);

