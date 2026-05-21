const path = require("path");
require("dotenv").config({ path: path.resolve(__dirname, "../.env") });
const mongoose = require("mongoose");

const deleteDatabase = async () => {
  try {
    console.log("🔗 Connecting to MongoDB...");
    console.log("MongoDB URI:", process.env.MONGO_URI);

    await mongoose.connect(process.env.MONGO_URI);
    console.log("✅ Connected to MongoDB");

    console.log("\n⚠️  DELETING DATABASE...");
    await mongoose.connection.dropDatabase();
    console.log("✅ Database deleted successfully!");

    console.log("\n📊 Database Status:");
    const collections = await mongoose.connection.db.listCollections().toArray();
    console.log(`   Collections remaining: ${collections.length}`);

    await mongoose.connection.close();
    console.log("\n✅ Connection closed.");
    process.exit(0);
  } catch (err) {
    console.error("❌ Error:", err.message);
    console.error(err);
    await mongoose.connection.close();
    process.exit(1);
  }
};

deleteDatabase();
