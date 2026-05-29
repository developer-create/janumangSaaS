const mongoose = require('mongoose');
const Permission = require('./src/models/permissionModel');
const Tenant = require('./src/models/tenantModel');
const { MODULES } = require("./src/config/modules");
const path = require("path");
require("dotenv").config({ path: path.resolve(__dirname, ".env") });

mongoose.connect(process.env.MONGO_URI || 'mongodb://localhost:27017/janumang_dev').then(async () => {
    const tenantId = '69fd7d3e74cdd63455781243';
    const tenant = await Tenant.findById(tenantId);
    const Plan = require("./src/models/planModel");
    const planConfig = await Plan.findOne({ planId: tenant.plan || "basic" });
    const coreModules = [];
    
    const allEnabledModules = [
      ...new Set([
        ...coreModules,
        ...(planConfig?.enabledModules || []),
        ...(tenant.enabledModules || []),
      ]),
    ];

    const permissions = await Permission.find({
      module: { $in: allEnabledModules },
      isActive: true,
    }).sort({ module: 1, name: 1 });
    
    console.log("Tenant perms count:", permissions.length);
    
    const permissionsByModule = {};
    permissions.forEach((perm) => {
      if (!permissionsByModule[perm.module]) {
        permissionsByModule[perm.module] = [];
      }
      permissionsByModule[perm.module].push(perm);
    });

    const orderedPermissions = [];
    Object.values(MODULES).forEach((module) => {
      if (
        permissionsByModule[module.id] &&
        allEnabledModules.includes(module.id)
      ) {
        orderedPermissions.push({
          module: module.id,
          moduleName: module.name,
          moduleDescription: module.description || "",
          permissions: permissionsByModule[module.id],
        });
      }
    });

    console.log("Ordered modules count:", orderedPermissions.length);
    
    mongoose.disconnect();
});
