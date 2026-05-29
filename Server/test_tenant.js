const mongoose = require('mongoose');
const Tenant = require('./src/models/tenantModel');
const path = require("path");
require("dotenv").config({ path: path.resolve(__dirname, ".env") });

mongoose.connect(process.env.MONGO_URI || 'mongodb://localhost:27017/janumang_dev').then(async () => {
    const tenantId = '69fd7d3e74cdd63455781243';
    const tenant = await Tenant.findById(tenantId);
    console.log("Tenant:", tenant ? tenant.name : "Not found");
    if (tenant) {
      console.log("Enabled modules:", tenant.enabledModules);
    }
    mongoose.disconnect();
});
