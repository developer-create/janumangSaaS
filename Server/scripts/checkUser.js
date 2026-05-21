const path = require("path");
require("dotenv").config({ path: path.resolve(__dirname, "../.env") });
const mongoose = require("mongoose");
const User = require("../src/models/userModel");
const Role = require("../src/models/roleModel");

const checkUser = async () => {
  try {
    console.log("🔗 Connecting to MongoDB...");
    await mongoose.connect(process.env.MONGO_URI);
    console.log("✅ Connected\n");

    const user = await User.findOne({ email: "superadmin@janumang.com" }).populate("role");
    console.log("Super Admin User:");
    console.log("  Email:", user?.email);
    console.log("  Level:", user?.level);
    console.log("  TenantId:", user?.tenantId);
    console.log("  Role:", user?.role?.name);
    console.log("  Full User:", JSON.stringify(user, null, 2));

    await mongoose.connection.close();
    process.exit(0);
  } catch (err) {
    console.error("❌ Error:", err.message);
    process.exit(1);
  }
};

checkUser();
