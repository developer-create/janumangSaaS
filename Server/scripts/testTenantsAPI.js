const path = require("path");
require("dotenv").config({ path: path.resolve(__dirname, "../.env") });
const jwt = require("jsonwebtoken");
const axios = require("axios");

const testAPI = async () => {
  try {
    // Generate a valid token for the super admin
    const superAdminId = "6a0c317ce59bc2fee32a8397";
    const token = jwt.sign({ id: superAdminId }, process.env.JWT_SECRET, {
      expiresIn: "15m",
    });

    console.log("🔑 Generated Token\n");

    // Test the tenants API
    console.log("📍 Testing GET /api/tenants...");
    const response = await axios.get("http://localhost:5000/api/tenants?limit=-1", {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    console.log("✅ Response Status:", response.status);
    console.log("📊 Tenants:");
    response.data.data?.forEach((t) => {
      console.log(`  - ${t.name} (ID: ${t._id})`);
    });

    process.exit(0);
  } catch (err) {
    console.error("❌ Error:", err.response?.status, err.response?.data || err.message);
    process.exit(1);
  }
};

testAPI();
