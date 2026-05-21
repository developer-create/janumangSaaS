const path = require("path");
require("dotenv").config({ path: path.resolve(__dirname, "../.env") });
const mongoose = require("mongoose");
const Tenant = require("../src/models/tenantModel");

const checkTenants = async () => {
  try {
    console.log("🔗 Connecting to MongoDB...");
    await mongoose.connect(process.env.MONGO_URI);
    console.log("✅ Connected\n");

    const allTenants = await Tenant.find();
    console.log("All Tenants in Database:");
    allTenants.forEach((t) => {
      console.log(`  - ${t.name} (ID: ${t._id})`);
    });

    // Check for the specific tenant ID from logs
    const specificId = "69fd7d3e74cdd63455781243";
    const tenant = await Tenant.findById(specificId);
    console.log(`\nTenant with ID ${specificId}:`, tenant ? tenant.name : "NOT FOUND");

    await mongoose.connection.close();
    process.exit(0);
  } catch (err) {
    console.error("❌ Error:", err.message);
    process.exit(1);
  }
};

checkTenants();
