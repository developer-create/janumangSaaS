/**
 * Simple Dummy Data Seeding Script
 * Seeds core master data for all modules
 */

const mongoose = require("mongoose");
const path = require("path");
require("dotenv").config({ path: path.resolve(__dirname, "../.env") });

// Import models
const State = require("../src/models/stateModel");
const Division = require("../src/models/divisionModel");
const District = require("../src/models/districtModel");
const Assembly = require("../src/models/assemblyModel");
const Block = require("../src/models/blockModel");
const Booth = require("../src/models/boothModel");
const Village = require("../src/models/villageModel");
const Panchayat = require("../src/models/panchayatModel");
const Party = require("../src/models/partyModel");
const Department = require("../src/models/departmentModel");
const WorkType = require("../src/models/worktypeModel");
const SubWorkType = require("../src/models/subTypeOfWorkModel");
const Parliament = require("../src/models/parliamentModel");
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

const seedData = async () => {
  try {
    console.log("\n🌱 Starting simple dummy data seeding...\n");

    // Get default tenant
    let tenant = await Tenant.findOne({ slug: "default" });
    if (!tenant) {
      tenant = await Tenant.findOne({ name: "Default" });
    }
    if (!tenant) {
      console.log("❌ Default tenant not found. Please run seedRolesAndAdmin.js first.");
      process.exit(1);
    }
    const tenantId = tenant._id;
    console.log("✅ Using default tenant");

    // Clear existing data
    console.log("🗑️  Clearing existing dummy data...");
    await State.deleteMany({});
    await Division.deleteMany({});
    await District.deleteMany({});
    await Assembly.deleteMany({});
    await Parliament.deleteMany({});
    await Block.deleteMany({});
    await Booth.deleteMany({});
    await Village.deleteMany({});
    await Panchayat.deleteMany({});
    await Party.deleteMany({});
    await Department.deleteMany({});
    await WorkType.deleteMany({});
    await SubWorkType.deleteMany({});
    console.log("✅ Cleared existing data\n");

    // ===== STATES =====
    console.log("📍 Seeding States...");
    const states = await State.insertMany([
      { name: "Maharashtra" },
      { name: "Gujarat" },
      { name: "Madhya Pradesh" },
      { name: "Rajasthan" },
      { name: "Uttar Pradesh" },
    ]);
    console.log(`✅ Created ${states.length} states`);

    // ===== DIVISIONS =====
    console.log("📍 Seeding Divisions...");
    const divisions = await Division.insertMany([
      { name: "Nagpur Division", state: states[0]._id, tenantId },
      { name: "Aurangabad Division", state: states[0]._id, tenantId },
      { name: "Ahmedabad Division", state: states[1]._id, tenantId },
      { name: "Indore Division", state: states[2]._id, tenantId },
      { name: "Jaipur Division", state: states[3]._id, tenantId },
    ]);
    console.log(`✅ Created ${divisions.length} divisions`);

    // ===== DISTRICTS =====
    console.log("📍 Seeding Districts...");
    const districts = await District.insertMany([
      { name: "Nagpur", state: states[0]._id, division: divisions[0]._id, tenantId },
      { name: "Wardha", state: states[0]._id, division: divisions[0]._id, tenantId },
      { name: "Aurangabad", state: states[0]._id, division: divisions[1]._id, tenantId },
      { name: "Ahmedabad", state: states[1]._id, division: divisions[2]._id, tenantId },
      { name: "Indore", state: states[2]._id, division: divisions[3]._id, tenantId },
    ]);
    console.log(`✅ Created ${districts.length} districts`);

    // ===== PARLIAMENTS =====
    console.log("📍 Seeding Parliaments...");
    const parliaments = await Parliament.insertMany([
      { name: "Nagpur Parliament", division: divisions[0]._id },
      { name: "Aurangabad Parliament", division: divisions[1]._id },
      { name: "Ahmedabad Parliament", division: divisions[2]._id },
      { name: "Indore Parliament", division: divisions[3]._id },
      { name: "Jaipur Parliament", division: divisions[4]._id },
    ]);
    console.log(`✅ Created ${parliaments.length} parliaments`);

    // ===== ASSEMBLIES =====
    console.log("📍 Seeding Assemblies...");
    const assemblies = await Assembly.insertMany([
      { name: "Nagpur Assembly", district: districts[0]._id, state: states[0]._id, division: divisions[0]._id, parliament: parliaments[0]._id, tenantId },
      { name: "Wardha Assembly", district: districts[1]._id, state: states[0]._id, division: divisions[0]._id, parliament: parliaments[0]._id, tenantId },
      { name: "Aurangabad Assembly", district: districts[2]._id, state: states[0]._id, division: divisions[1]._id, parliament: parliaments[1]._id, tenantId },
      { name: "Ahmedabad Assembly", district: districts[3]._id, state: states[1]._id, division: divisions[2]._id, parliament: parliaments[2]._id, tenantId },
      { name: "Indore Assembly", district: districts[4]._id, state: states[2]._id, division: divisions[3]._id, parliament: parliaments[3]._id, tenantId },
    ]);
    console.log(`✅ Created ${assemblies.length} assemblies`);

    // ===== BLOCKS =====
    console.log("📍 Seeding Blocks...");
    const blocks = await Block.insertMany([
      { name: "Nagpur Block", district: districts[0]._id, state: states[0]._id, tenantId },
      { name: "Wardha Block", district: districts[1]._id, state: states[0]._id, tenantId },
      { name: "Aurangabad Block", district: districts[2]._id, state: states[0]._id, tenantId },
      { name: "Ahmedabad Block", district: districts[3]._id, state: states[1]._id, tenantId },
      { name: "Indore Block", district: districts[4]._id, state: states[2]._id, tenantId },
    ]);
    console.log(`✅ Created ${blocks.length} blocks`);

    // ===== BOOTHS =====
    console.log("📍 Seeding Booths...");
    const booths = await Booth.insertMany([
      { name: "Booth 001", code: "B001", block: blocks[0]._id, assembly: assemblies[0]._id, tenantId },
      { name: "Booth 002", code: "B002", block: blocks[0]._id, assembly: assemblies[0]._id, tenantId },
      { name: "Booth 003", code: "B003", block: blocks[1]._id, assembly: assemblies[1]._id, tenantId },
      { name: "Booth 004", code: "B004", block: blocks[2]._id, assembly: assemblies[2]._id, tenantId },
      { name: "Booth 005", code: "B005", block: blocks[3]._id, assembly: assemblies[3]._id, tenantId },
    ]);
    console.log(`✅ Created ${booths.length} booths`);

    // ===== PANCHAYATS (create first) =====
    console.log("📍 Seeding Panchayats...");
    const panchayats = await Panchayat.insertMany([
      { name: "Panchayat A", block: blocks[0]._id, booth: booths[0]._id, tenantId },
      { name: "Panchayat B", block: blocks[0]._id, booth: booths[1]._id, tenantId },
      { name: "Panchayat C", block: blocks[1]._id, booth: booths[2]._id, tenantId },
      { name: "Panchayat D", block: blocks[2]._id, booth: booths[3]._id, tenantId },
      { name: "Panchayat E", block: blocks[3]._id, booth: booths[4]._id, tenantId },
    ]);
    console.log(`✅ Created ${panchayats.length} panchayats`);

    // ===== VILLAGES =====
    console.log("📍 Seeding Villages...");
    const villages = await Village.insertMany([
      { name: "Village A", block: blocks[0]._id, district: districts[0]._id, booth: booths[0]._id, panchayat: panchayats[0]._id, tenantId },
      { name: "Village B", block: blocks[0]._id, district: districts[0]._id, booth: booths[1]._id, panchayat: panchayats[1]._id, tenantId },
      { name: "Village C", block: blocks[1]._id, district: districts[1]._id, booth: booths[2]._id, panchayat: panchayats[2]._id, tenantId },
      { name: "Village D", block: blocks[2]._id, district: districts[2]._id, booth: booths[3]._id, panchayat: panchayats[3]._id, tenantId },
      { name: "Village E", block: blocks[3]._id, district: districts[3]._id, booth: booths[4]._id, panchayat: panchayats[4]._id, tenantId },
    ]);
    console.log(`✅ Created ${villages.length} villages`);

    // ===== PARTIES =====
    console.log("📍 Seeding Parties...");
    const parties = await Party.insertMany([
      { name: "Indian National Congress", abbreviation: "INC", tenantId },
      { name: "Bharatiya Janata Party", abbreviation: "BJP", tenantId },
      { name: "Shiv Sena", abbreviation: "SS", tenantId },
      { name: "Nationalist Congress Party", abbreviation: "NCP", tenantId },
      { name: "Aam Aadmi Party", abbreviation: "AAP", tenantId },
    ]);
    console.log(`✅ Created ${parties.length} parties`);

    // ===== DEPARTMENTS =====
    console.log("📍 Seeding Departments...");
    const departments = await Department.insertMany([
      { name: "Public Works", tenantId },
      { name: "Health", tenantId },
      { name: "Education", tenantId },
      { name: "Agriculture", tenantId },
      { name: "Finance", tenantId },
    ]);
    console.log(`✅ Created ${departments.length} departments`);

    // ===== WORK TYPES =====
    console.log("📍 Seeding Work Types...");
    const workTypes = await WorkType.insertMany([
      { name: "Road Construction", tenantId },
      { name: "School Building", tenantId },
      { name: "Hospital Setup", tenantId },
      { name: "Water Supply", tenantId },
      { name: "Electricity", tenantId },
    ]);
    console.log(`✅ Created ${workTypes.length} work types`);

    // ===== SUB WORK TYPES =====
    console.log("📍 Seeding Sub Work Types...");
    const subWorkTypes = await SubWorkType.insertMany([
      { typeOfWork: "Road Construction", subTypeOfWork: "Asphalt Road", tenantId },
      { typeOfWork: "Road Construction", subTypeOfWork: "Concrete Road", tenantId },
      { typeOfWork: "School Building", subTypeOfWork: "Primary School", tenantId },
      { typeOfWork: "School Building", subTypeOfWork: "Secondary School", tenantId },
      { typeOfWork: "Hospital Setup", subTypeOfWork: "General Hospital", tenantId },
    ]);
    console.log(`✅ Created ${subWorkTypes.length} sub work types`);

    console.log("\n" + "=".repeat(60));
    console.log("✅ ALL DUMMY DATA SEEDED SUCCESSFULLY!");
    console.log("=".repeat(60));
    console.log("\n📊 Summary:");
    console.log(`   • States: ${states.length}`);
    console.log(`   • Divisions: ${divisions.length}`);
    console.log(`   • Districts: ${districts.length}`);
    console.log(`   • Parliaments: ${parliaments.length}`);
    console.log(`   • Assemblies: ${assemblies.length}`);
    console.log(`   • Blocks: ${blocks.length}`);
    console.log(`   • Booths: ${booths.length}`);
    console.log(`   • Villages: ${villages.length}`);
    console.log(`   • Panchayats: ${panchayats.length}`);
    console.log(`   • Parties: ${parties.length}`);
    console.log(`   • Departments: ${departments.length}`);
    console.log(`   • Work Types: ${workTypes.length}`);
    console.log(`   • Sub Work Types: ${subWorkTypes.length}`);
    console.log("=".repeat(60) + "\n");
  } catch (error) {
    console.error("❌ Error seeding data:", error.message);
    process.exit(1);
  }
};

const main = async () => {
  await connectDB();
  await seedData();
  await mongoose.connection.close();
  console.log("✅ Database connection closed.");
  process.exit(0);
};

main();
