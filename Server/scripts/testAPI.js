const path = require("path");
require("dotenv").config({ path: path.resolve(__dirname, "../.env") });
const jwt = require("jsonwebtoken");
const axios = require("axios");

const testAPI = async () => {
  try {
    // Generate a valid token for the super admin
    const superAdminId = "6a0c317ce59bc2fee32a8397"; // From earlier check
    const token = jwt.sign({ id: superAdminId }, process.env.JWT_SECRET, {
      expiresIn: "15m",
    });

    console.log("🔑 Generated Token:", token.substring(0, 50) + "...\n");

    // Test the panchayat API
    console.log("📍 Testing GET /api/panchayat...");
    const response = await axios.get("http://localhost:5000/api/panchayat", {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    console.log("✅ Response Status:", response.status);
    console.log("📊 Data Count:", response.data.data?.length || 0);
    console.log("📋 Sample Data:", JSON.stringify(response.data.data?.[0], null, 2));

    process.exit(0);
  } catch (err) {
    console.error("❌ Error:", err.response?.status, err.response?.data || err.message);
    process.exit(1);
  }
};

testAPI();
