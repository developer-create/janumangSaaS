const axios = require("axios");

const testLogin = async () => {
  try {
    console.log("🔐 Testing Login...");
    const response = await axios.post("http://localhost:5000/api/auth/login", {
      email: "superadmin@janumang.com",
      password: "Admin@123456",
    });

    console.log("✅ Login Successful!");
    console.log("📊 Response Data:");
    console.log(JSON.stringify(response.data, null, 2));

    process.exit(0);
  } catch (err) {
    console.error("❌ Error:", err.response?.status, err.response?.data || err.message);
    process.exit(1);
  }
};

testLogin();
