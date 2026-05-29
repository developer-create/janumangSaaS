const mongoose = require('mongoose');
const Role = require('./src/models/roleModel');
const Permission = require('./src/models/permissionModel');
const path = require("path");
require("dotenv").config({ path: path.resolve(__dirname, ".env") });

mongoose.connect(process.env.MONGO_URI || 'mongodb://localhost:27017/janumang_dev').then(async () => {
    const roleId = '69fd7d3e74cdd63455781251'; // From user log
    const role = await Role.findById(roleId).populate('permissions');
    if(role) {
      console.log("Role name:", role.name);
      console.log("Permissions count:", role.permissions.length);
      if (role.permissions.length > 0) {
        console.log("Type of first permission _id:", typeof role.permissions[0]._id);
        console.log("First permission _id value:", role.permissions[0]._id);
      }
    } else {
      console.log("Role not found");
    }
    mongoose.disconnect();
});
