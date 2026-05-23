/**
 * Seed Members with Complete Data
 */

const mongoose = require("mongoose");
const path = require("path");
require("dotenv").config({ path: path.resolve(__dirname, "../.env") });

const Member = require("../src/models/memberModel");
const District = require("../src/models/districtModel");
const Block = require("../src/models/blockModel");
const Tenant = require("../src/models/tenantModel");

const connectDB = async () => {
  try {
    await mongoose.connect(process.env.MONGO_URI);
    console.log("✅ MongoDB connected successfully");
  } catch (error) {
    console.error("❌ MongoDB connection error:", error);
    process.exit(1);
  }
};

const seedMembers = async () => {
  try {
    console.log("\n🌱 Starting member data seeding...\n");

    // Get or create default tenant
    let tenant = await Tenant.findOne({ slug: "default" });
    if (!tenant) {
      tenant = await Tenant.findOne({ name: "Default Tenant" });
    }
    if (!tenant) {
      console.log("Creating default tenant...");
      tenant = await Tenant.create({
        name: "Default Tenant",
        slug: "default",
        isActive: true,
      });
    }
    const tenantId = tenant._id;
    console.log(`✅ Using tenant: ${tenant.name}`);

    // Get districts and blocks
    const districts = await District.find().limit(5);
    const blocks = await Block.find().limit(10);

    if (districts.length === 0 || blocks.length === 0) {
      console.log("❌ No districts or blocks found. Please run seedDummyData.js first.");
      process.exit(1);
    }

    console.log(`✅ Found ${districts.length} districts and ${blocks.length} blocks`);

    // Clear existing members
    console.log("🗑️  Clearing existing members...");
    await Member.deleteMany({});

    // Sample member data
    const memberNames = [
      { name: "Rajesh Kumar", fatherName: "Ram Kumar", mobile: "9876543210" },
      { name: "Priya Singh", fatherName: "Rajendra Singh", mobile: "9876543211" },
      { name: "Amit Patel", fatherName: "Vikram Patel", mobile: "9876543212" },
      { name: "Neha Sharma", fatherName: "Arun Sharma", mobile: "9876543213" },
      { name: "Vikram Verma", fatherName: "Suresh Verma", mobile: "9876543214" },
      { name: "Anjali Gupta", fatherName: "Rajesh Gupta", mobile: "9876543215" },
      { name: "Sanjay Kumar", fatherName: "Mohan Kumar", mobile: "9876543216" },
      { name: "Deepika Yadav", fatherName: "Ashok Yadav", mobile: "9876543217" },
      { name: "Rohit Singh", fatherName: "Harendra Singh", mobile: "9876543218" },
      { name: "Kavya Nair", fatherName: "Krishnan Nair", mobile: "9876543219" },
    ];

    const codes = ["BC", "PP", "IP", "FH", "SMM", "MS", "FP", "ER", "BLA", "FM"];
    const vehicles = ["Bike", "Car", ""];
    const genders = ["Male", "Female"];
    const educations = ["10th Pass", "12th Pass", "Graduate", "Post Graduate"];
    const parties = ["BJP", "INC", "SS", "NCP", "AAP"];
    const groups = ["Group A", "Group B", "Group C"];

    const membersToCreate = memberNames.map((member, index) => ({
      memberType: "vidhan-sabha",
      name: member.name,
      fatherName: member.fatherName,
      mobile: member.mobile,
      voterId: `VOT${String(index + 1).padStart(6, "0")}`,
      district: districts[index % districts.length]._id,
      block: blocks[index % blocks.length]._id,
      village: `Village ${String.fromCharCode(65 + (index % 5))}`,
      grampanchayat: `Grampanchayat ${index + 1}`,
      boothName: `Booth ${String(index + 1).padStart(3, "0")}`,
      boothNumber: String(index + 1),
      samiti: `Samiti ${String.fromCharCode(65 + (index % 3))}`,
      toll: `Toll ${index + 1}`,
      jaati: `Jaati ${String.fromCharCode(65 + (index % 4))}`,
      age: 25 + (index % 40),
      education: educations[index % educations.length],
      address: `Address ${index + 1}, City`,
      gender: genders[index % 2],
      vehicle: vehicles[index % 3],
      govtEmployee: index % 3 === 0 ? "Yes" : "No",
      party: parties[index % parties.length],
      postYear: "2024",
      code: codes[index % codes.length],
      group: groups[index % groups.length],
      nariSammanYojna: index % 2 === 0 ? "Yes" : "No",
      farmerLoanWaiver: index % 3 === 0 ? "Yes" : "No",
      facebook: `facebook.com/user${index + 1}`,
      instagram: `@user${index + 1}`,
      twitter: `@user${index + 1}`,
      reference: `Reference ${index + 1}`,
      remark: `Sample member ${index + 1}`,
      addedBy: "System",
      tenantId,
      startLat: 21.1458 + (index * 0.01),
      startLong: 79.0882 + (index * 0.01),
      endLat: 21.1458 + (index * 0.01),
      endLong: 79.0882 + (index * 0.01),
    }));

    const createdMembers = await Member.insertMany(membersToCreate);
    console.log(`✅ Created ${createdMembers.length} members with complete data`);

    console.log("\n✅ Member data seeded successfully!\n");
  } catch (error) {
    console.error("❌ Error seeding members:", error);
    process.exit(1);
  }
};

const main = async () => {
  await connectDB();
  await seedMembers();
  await mongoose.connection.close();
  console.log("✅ Database connection closed.");
  process.exit(0);
};

main();
