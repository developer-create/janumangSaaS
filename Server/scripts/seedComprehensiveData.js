const path = require("path");
require("dotenv").config({ path: path.resolve(__dirname, "../.env") });
const mongoose = require("mongoose");

// Import all models
const State = require("../src/models/stateModel");
const Division = require("../src/models/divisionModel");
const District = require("../src/models/districtModel");
const Block = require("../src/models/blockModel");
const Booth = require("../src/models/boothModel");
const Panchayat = require("../src/models/panchayatModel");
const Village = require("../src/models/villageModel");
const Parliament = require("../src/models/parliamentModel");
const Assembly = require("../src/models/assemblyModel");
const Party = require("../src/models/partyModel");
const Department = require("../src/models/departmentModel");
const WorkType = require("../src/models/workTypeModel");
const SubWorkType = require("../src/models/subTypeOfWorkModel");
const Member = require("../src/models/memberModel");
const Voter = require("../src/models/voterModel");
const Visitor = require("../src/models/visitorModel");
const Event = require("../src/models/eventModel");
const Project = require("../src/models/projectModel");
const Tenant = require("../src/models/tenantModel");
const User = require("../src/models/userModel");

const seedComprehensiveData = async () => {
  try {
    console.log("🔗 Connecting to MongoDB...");
    await mongoose.connect(process.env.MONGO_URI);
    console.log("✅ Connected to MongoDB\n");

    // Get default tenant
    let tenant = await Tenant.findOne({ name: "Default Tenant" });
    if (!tenant) {
      tenant = await Tenant.create({
        name: "Default Tenant",
        slug: "default-tenant",
        isActive: true,
      });
    }
    const tenantId = tenant._id;
    console.log(`📍 Using Tenant: ${tenant.name}\n`);

    // Get super admin user
    const superAdmin = await User.findOne({ email: "superadmin@janumang.com" });

    // ============ CLEAR EXISTING DATA ============
    console.log("🗑️  Clearing existing data...");
    await State.deleteMany({});
    await Division.deleteMany({});
    await District.deleteMany({});
    await Block.deleteMany({});
    await Booth.deleteMany({});
    await Panchayat.deleteMany({});
    await Village.deleteMany({});
    await Parliament.deleteMany({});
    await Assembly.deleteMany({});
    await Party.deleteMany({});
    await Department.deleteMany({});
    await WorkType.deleteMany({});
    await SubWorkType.deleteMany({});
    await Member.deleteMany({});
    await Voter.deleteMany({});
    await Visitor.deleteMany({});
    await Event.deleteMany({});
    await Project.deleteMany({});
    console.log("✅ Cleared existing data\n");

    // ============ STATES ============
    console.log("📍 Seeding States...");
    const states = await State.insertMany([
      { name: "Madhya Pradesh", code: "MP", tenantId },
      { name: "Rajasthan", code: "RJ", tenantId },
      { name: "Gujarat", code: "GJ", tenantId },
      { name: "Uttar Pradesh", code: "UP", tenantId },
      { name: "Bihar", code: "BR", tenantId },
    ]);
    console.log(`✅ Created ${states.length} states\n`);

    // ============ DIVISIONS ============
    console.log("📍 Seeding Divisions...");
    const divisions = await Division.insertMany([
      { name: "Indore Division", state: states[0]._id, tenantId },
      { name: "Bhopal Division", state: states[0]._id, tenantId },
      { name: "Jabalpur Division", state: states[0]._id, tenantId },
      { name: "Jaipur Division", state: states[1]._id, tenantId },
      { name: "Ahmedabad Division", state: states[2]._id, tenantId },
    ]);
    console.log(`✅ Created ${divisions.length} divisions\n`);

    // ============ DISTRICTS ============
    console.log("📍 Seeding Districts...");
    const districts = await District.insertMany([
      { name: "Indore", state: states[0]._id, division: divisions[0]._id, tenantId },
      { name: "Dhar", state: states[0]._id, division: divisions[0]._id, tenantId },
      { name: "Bhopal", state: states[0]._id, division: divisions[1]._id, tenantId },
      { name: "Raisen", state: states[0]._id, division: divisions[1]._id, tenantId },
      { name: "Jabalpur", state: states[0]._id, division: divisions[2]._id, tenantId },
      { name: "Jaipur", state: states[1]._id, division: divisions[3]._id, tenantId },
    ]);
    console.log(`✅ Created ${districts.length} districts\n`);

    // ============ PARLIAMENTS ============
    console.log("📍 Seeding Parliaments...");
    const parliaments = await Parliament.insertMany([
      { name: "Indore", district: districts[0]._id, division: divisions[0]._id, tenantId },
      { name: "Dhar", district: districts[1]._id, division: divisions[0]._id, tenantId },
      { name: "Bhopal", district: districts[2]._id, division: divisions[1]._id, tenantId },
      { name: "Raisen", district: districts[3]._id, division: divisions[1]._id, tenantId },
      { name: "Jabalpur", district: districts[4]._id, division: divisions[2]._id, tenantId },
    ]);
    console.log(`✅ Created ${parliaments.length} parliaments\n`);

    // ============ ASSEMBLIES ============
    console.log("📍 Seeding Assemblies (Vidhan Sabha)...");
    const assemblies = await Assembly.insertMany([
      { name: "Indore Assembly", parliament: parliaments[0]._id, district: districts[0]._id, state: states[0]._id, division: divisions[0]._id, tenantId },
      { name: "Mhow Assembly", parliament: parliaments[0]._id, district: districts[0]._id, state: states[0]._id, division: divisions[0]._id, tenantId },
      { name: "Bhopal Assembly", parliament: parliaments[2]._id, district: districts[2]._id, state: states[0]._id, division: divisions[1]._id, tenantId },
      { name: "Sehore Assembly", parliament: parliaments[2]._id, district: districts[2]._id, state: states[0]._id, division: divisions[1]._id, tenantId },
      { name: "Jabalpur Assembly", parliament: parliaments[4]._id, district: districts[4]._id, state: states[0]._id, division: divisions[2]._id, tenantId },
    ]);
    console.log(`✅ Created ${assemblies.length} assemblies\n`);

    // ============ BLOCKS ============
    console.log("📍 Seeding Blocks...");
    const blocks = await Block.insertMany([
      { name: "Indore Block", district: districts[0]._id, tenantId },
      { name: "Mhow Block", district: districts[0]._id, tenantId },
      { name: "Bhopal Block", district: districts[2]._id, tenantId },
      { name: "Sehore Block", district: districts[3]._id, tenantId },
      { name: "Jabalpur Block", district: districts[4]._id, tenantId },
    ]);
    console.log(`✅ Created ${blocks.length} blocks\n`);

    // ============ BOOTHS ============
    console.log("📍 Seeding Booths...");
    const booths = await Booth.insertMany([
      { name: "Booth 1", code: "B001", block: blocks[0]._id, district: districts[0]._id, tenantId },
      { name: "Booth 2", code: "B002", block: blocks[0]._id, district: districts[0]._id, tenantId },
      { name: "Booth 3", code: "B003", block: blocks[1]._id, district: districts[0]._id, tenantId },
      { name: "Booth 4", code: "B004", block: blocks[2]._id, district: districts[2]._id, tenantId },
      { name: "Booth 5", code: "B005", block: blocks[4]._id, district: districts[4]._id, tenantId },
    ]);
    console.log(`✅ Created ${booths.length} booths\n`);

    // ============ PANCHAYATS ============
    console.log("📍 Seeding Panchayats...");
    const panchayats = await Panchayat.insertMany([
      { name: "Indore Panchayat", block: blocks[0]._id, booth: booths[0]._id, district: districts[0]._id, tenantId },
      { name: "Mhow Panchayat", block: blocks[1]._id, booth: booths[2]._id, district: districts[0]._id, tenantId },
      { name: "Bhopal Panchayat", block: blocks[2]._id, booth: booths[3]._id, district: districts[2]._id, tenantId },
      { name: "Sehore Panchayat", block: blocks[3]._id, booth: booths[3]._id, district: districts[3]._id, tenantId },
      { name: "Jabalpur Panchayat", block: blocks[4]._id, booth: booths[4]._id, district: districts[4]._id, tenantId },
    ]);
    console.log(`✅ Created ${panchayats.length} panchayats\n`);

    // ============ VILLAGES ============
    console.log("📍 Seeding Villages...");
    const villages = await Village.insertMany([
      { name: "Village A", booth: booths[0]._id, panchayat: panchayats[0]._id, block: blocks[0]._id, district: districts[0]._id, tenantId },
      { name: "Village B", booth: booths[1]._id, panchayat: panchayats[0]._id, block: blocks[0]._id, district: districts[0]._id, tenantId },
      { name: "Village C", booth: booths[2]._id, panchayat: panchayats[1]._id, block: blocks[1]._id, district: districts[0]._id, tenantId },
      { name: "Village D", booth: booths[3]._id, panchayat: panchayats[2]._id, block: blocks[2]._id, district: districts[2]._id, tenantId },
      { name: "Village E", booth: booths[4]._id, panchayat: panchayats[4]._id, block: blocks[4]._id, district: districts[4]._id, tenantId },
    ]);
    console.log(`✅ Created ${villages.length} villages\n`);

    // ============ PARTIES ============
    console.log("📍 Seeding Parties...");
    const parties = await Party.insertMany([
      { name: "Indian National Congress", shortName: "INC", symbol: "Hand", tenantId },
      { name: "Bharatiya Janata Party", shortName: "BJP", symbol: "Lotus", tenantId },
      { name: "Aam Aadmi Party", shortName: "AAP", symbol: "Broom", tenantId },
      { name: "Shiv Sena", shortName: "SS", symbol: "Bow and Arrow", tenantId },
      { name: "Samajwadi Party", shortName: "SP", symbol: "Bicycle", tenantId },
    ]);
    console.log(`✅ Created ${parties.length} parties\n`);

    // ============ DEPARTMENTS ============
    console.log("📍 Seeding Departments...");
    const departments = await Department.insertMany([
      { name: "Administration", code: "ADM", tenantId },
      { name: "Finance", code: "FIN", tenantId },
      { name: "Health", code: "HLT", tenantId },
      { name: "Education", code: "EDU", tenantId },
      { name: "Public Works", code: "PWD", tenantId },
    ]);
    console.log(`✅ Created ${departments.length} departments\n`);

    // ============ WORK TYPES ============
    console.log("📍 Seeding Work Types...");
    const workTypes = await WorkType.insertMany([
      { name: "Road Construction", code: "RC", tenantId },
      { name: "School Building", code: "SB", tenantId },
      { name: "Health Center", code: "HC", tenantId },
      { name: "Water Supply", code: "WS", tenantId },
      { name: "Electricity", code: "EL", tenantId },
    ]);
    console.log(`✅ Created ${workTypes.length} work types\n`);

    // ============ SUB WORK TYPES ============
    console.log("📍 Seeding Sub Work Types...");
    const subWorkTypes = await SubWorkType.insertMany([
      { typeOfWork: "Road Construction", subTypeOfWork: "Asphalt Road", tenantId },
      { typeOfWork: "Road Construction", subTypeOfWork: "Concrete Road", tenantId },
      { typeOfWork: "School Building", subTypeOfWork: "Primary School", tenantId },
      { typeOfWork: "School Building", subTypeOfWork: "Secondary School", tenantId },
      { typeOfWork: "Health Center", subTypeOfWork: "Primary Health Center", tenantId },
    ]);
    console.log(`✅ Created ${subWorkTypes.length} sub work types\n`);

    // ============ MEMBERS ============
    console.log("📍 Seeding Members...");
    const members = await Member.insertMany([
      {
        name: "Rajesh Kumar",
        email: "rajesh@example.com",
        mobileNo: "9876543210",
        position: "Sarpanch",
        district: districts[0]._id,
        block: blocks[0]._id,
        panchayat: panchayats[0]._id,
        parliament: parliaments[0]._id,
        tenantId,
        createdBy: superAdmin._id,
      },
      {
        name: "Priya Singh",
        email: "priya@example.com",
        mobileNo: "9876543211",
        position: "Gram Sevak",
        district: districts[0]._id,
        block: blocks[1]._id,
        panchayat: panchayats[1]._id,
        parliament: parliaments[0]._id,
        tenantId,
        createdBy: superAdmin._id,
      },
      {
        name: "Amit Patel",
        email: "amit@example.com",
        mobileNo: "9876543212",
        position: "Councilor",
        district: districts[2]._id,
        block: blocks[2]._id,
        panchayat: panchayats[2]._id,
        parliament: parliaments[2]._id,
        tenantId,
        createdBy: superAdmin._id,
      },
      {
        name: "Neha Sharma",
        email: "neha@example.com",
        mobileNo: "9876543213",
        position: "Ward Member",
        district: districts[3]._id,
        block: blocks[3]._id,
        panchayat: panchayats[3]._id,
        parliament: parliaments[3]._id,
        tenantId,
        createdBy: superAdmin._id,
      },
      {
        name: "Vikram Verma",
        email: "vikram@example.com",
        mobileNo: "9876543214",
        position: "Mukhiya",
        district: districts[4]._id,
        block: blocks[4]._id,
        panchayat: panchayats[4]._id,
        parliament: parliaments[4]._id,
        tenantId,
        createdBy: superAdmin._id,
      },
    ]);
    console.log(`✅ Created ${members.length} members\n`);

    // ============ VOTERS ============
    console.log("📍 Seeding Voters...");
    const voters = [];
    const voterData = [
      {
        voterId: "V001",
        name: "Voter One",
        mobileNumber: "9111111111",
        fatherName: "Father One",
        age: 35,
        fulladdress: "Village A, Indore",
        booth: booths[0]._id,
        village: "Village A",
        panchayat: panchayats[0]._id,
        block: blocks[0]._id,
        district: districts[0]._id,
        state: states[0]._id,
        division: divisions[0]._id,
        parliament: parliaments[0]._id,
        assembly: assemblies[0]._id,
        tenantId,
        createdBy: superAdmin._id,
      },
      {
        voterId: "V002",
        name: "Voter Two",
        mobileNumber: "9111111112",
        fatherName: "Father Two",
        age: 42,
        fulladdress: "Village B, Indore",
        booth: booths[1]._id,
        village: "Village B",
        panchayat: panchayats[0]._id,
        block: blocks[0]._id,
        district: districts[0]._id,
        state: states[0]._id,
        division: divisions[0]._id,
        parliament: parliaments[0]._id,
        assembly: assemblies[0]._id,
        tenantId,
        createdBy: superAdmin._id,
      },
      {
        voterId: "V003",
        name: "Voter Three",
        mobileNumber: "9111111113",
        fatherName: "Father Three",
        age: 28,
        fulladdress: "Village C, Mhow",
        booth: booths[2]._id,
        village: "Village C",
        panchayat: panchayats[1]._id,
        block: blocks[1]._id,
        district: districts[0]._id,
        state: states[0]._id,
        division: divisions[0]._id,
        parliament: parliaments[1]._id,
        assembly: assemblies[1]._id,
        tenantId,
        createdBy: superAdmin._id,
      },
      {
        voterId: "V004",
        name: "Voter Four",
        mobileNumber: "9111111114",
        fatherName: "Father Four",
        age: 55,
        fulladdress: "Village D, Bhopal",
        booth: booths[3]._id,
        village: "Village D",
        panchayat: panchayats[2]._id,
        block: blocks[2]._id,
        district: districts[2]._id,
        state: states[0]._id,
        division: divisions[1]._id,
        parliament: parliaments[2]._id,
        assembly: assemblies[2]._id,
        tenantId,
        createdBy: superAdmin._id,
      },
      {
        voterId: "V005",
        name: "Voter Five",
        mobileNumber: "9111111115",
        fatherName: "Father Five",
        age: 38,
        fulladdress: "Village E, Jabalpur",
        booth: booths[4]._id,
        village: "Village E",
        panchayat: panchayats[4]._id,
        block: blocks[4]._id,
        district: districts[4]._id,
        state: states[0]._id,
        division: divisions[2]._id,
        parliament: parliaments[4]._id,
        assembly: assemblies[4]._id,
        tenantId,
        createdBy: superAdmin._id,
      },
    ];

    // Create voters one by one to trigger pre-save hook
    for (const data of voterData) {
      const voter = await Voter.create(data);
      voters.push(voter);
    }
    console.log(`✅ Created ${voters.length} voters\n`);

    // ============ VISITORS ============
    console.log("📍 Seeding Visitors...");
    const visitors = await Visitor.insertMany([
      {
        name: "Guest One",
        mobileNumber: "9222222221",
        district: "Indore",
        vidhansabha: "Indore Assembly",
        block: "Indore Block",
        date: "2026-06-15",
        time: "10:00 AM",
        category: "Official",
        post: "Officer",
        place: "District Office",
        incomingVisitor: "VISITOR",
        message: "Official Meeting",
        visitorType: "Government Official",
        attendBy: "Admin",
        remarks: "Meeting completed",
        bhaiyakanirdesh: "Approved",
        addedBy: "superadmin@janumang.com",
        tenantId,
      },
      {
        name: "Guest Two",
        mobileNumber: "9222222222",
        district: "Bhopal",
        vidhansabha: "Bhopal Assembly",
        block: "Bhopal Block",
        date: "2026-06-20",
        time: "02:00 PM",
        category: "Consultation",
        post: "Consultant",
        place: "Conference Room",
        incomingVisitor: "INCOMING",
        message: "Project Consultation",
        visitorType: "External Consultant",
        attendBy: "Manager",
        remarks: "Consultation session",
        bhaiyakanirdesh: "Pending",
        addedBy: "superadmin@janumang.com",
        tenantId,
      },
      {
        name: "Guest Three",
        mobileNumber: "9222222223",
        district: "Jabalpur",
        vidhansabha: "Jabalpur Assembly",
        block: "Jabalpur Block",
        date: "2026-07-01",
        time: "11:00 AM",
        category: "Discussion",
        post: "Project Lead",
        place: "Meeting Hall",
        incomingVisitor: "VISITOR",
        message: "Project Discussion",
        visitorType: "Project Team",
        attendBy: "Coordinator",
        remarks: "Discussion completed",
        bhaiyakanirdesh: "Approved",
        addedBy: "superadmin@janumang.com",
        tenantId,
      },
    ]);
    console.log(`✅ Created ${visitors.length} visitors\n`);

    // ============ EVENTS ============
    console.log("📍 Seeding Events...");
    const events = [];
    const eventData = [
      {
        district: "Indore",
        year: "2026",
        month: "June",
        receivingDate: new Date("2026-06-10"),
        programDate: new Date("2026-06-15"),
        time: "10:00 AM",
        eventType: "Community Meeting",
        eventDetails: "Monthly community gathering for local issues",
        status: "Scheduled",
        priority: "High",
        venueCity: "Indore",
        referencePerson: "Rajesh Kumar",
        contactNumber: "9876543210",
        address: "Community Center, Indore",
        name: "Community Meeting",
        location: "Indore",
        probability: "High",
        duration: "2 hours",
        attended: "No",
        pressConference: "No",
        remarks: "Important community gathering",
        addedBy: "superadmin@janumang.com",
        tenantId,
      },
      {
        district: "Bhopal",
        year: "2026",
        month: "June",
        receivingDate: new Date("2026-06-15"),
        programDate: new Date("2026-06-20"),
        time: "02:00 PM",
        eventType: "Health Camp",
        eventDetails: "Free health checkup camp for all citizens",
        status: "Confirmed",
        priority: "Medium",
        venueCity: "Bhopal",
        referencePerson: "Dr. Amit Patel",
        contactNumber: "9876543212",
        address: "Government Hospital, Bhopal",
        name: "Health Camp",
        location: "Bhopal",
        probability: "High",
        duration: "4 hours",
        attended: "No",
        pressConference: "Yes",
        remarks: "Health awareness program",
        addedBy: "superadmin@janumang.com",
        tenantId,
      },
      {
        district: "Jabalpur",
        year: "2026",
        month: "July",
        receivingDate: new Date("2026-06-25"),
        programDate: new Date("2026-07-01"),
        time: "11:00 AM",
        eventType: "Educational Workshop",
        eventDetails: "Skill development workshop for youth",
        status: "Scheduled",
        priority: "Medium",
        venueCity: "Jabalpur",
        referencePerson: "Vikram Verma",
        contactNumber: "9876543214",
        address: "Training Center, Jabalpur",
        name: "Educational Workshop",
        location: "Jabalpur",
        probability: "Medium",
        duration: "3 days",
        attended: "No",
        pressConference: "No",
        remarks: "Skill development initiative",
        addedBy: "superadmin@janumang.com",
        tenantId,
      },
    ];

    // Create events one by one to trigger pre-save hook
    for (const data of eventData) {
      const event = await Event.create(data);
      events.push(event);
    }
    console.log(`✅ Created ${events.length} events\n`);

    // ============ PROJECTS ============
    console.log("📍 Seeding Projects...");
    const projects = await Project.insertMany([
      {
        district: "Indore",
        block: "Indore Block",
        department: "Public Works",
        workName: "Road Development Project",
        projectCost: 5000000,
        proposalEstimate: 5500000,
        tsNoDate: "TS/2026/001",
        asNoDate: "AS/2026/001",
        status: "In Progress",
        officerName: "Rajesh Kumar",
        contactNumber: "9876543210",
        remarks: "Development of rural roads in progress",
        currentProgress: "60%",
        tenantId,
      },
      {
        district: "Bhopal",
        block: "Bhopal Block",
        department: "Education",
        workName: "School Construction",
        projectCost: 2000000,
        proposalEstimate: 2200000,
        tsNoDate: "TS/2026/002",
        asNoDate: "AS/2026/002",
        status: "Pending",
        officerName: "Amit Patel",
        contactNumber: "9876543212",
        remarks: "Building new primary school",
        currentProgress: "10%",
        tenantId,
      },
      {
        district: "Jabalpur",
        block: "Jabalpur Block",
        department: "Public Works",
        workName: "Water Supply System",
        projectCost: 1500000,
        proposalEstimate: 1600000,
        tsNoDate: "TS/2026/003",
        asNoDate: "AS/2026/003",
        status: "Completed",
        officerName: "Vikram Verma",
        contactNumber: "9876543214",
        remarks: "Installation of water supply completed",
        currentProgress: "100%",
        tenantId,
      },
    ]);
    console.log(`✅ Created ${projects.length} projects\n`);

    console.log("\n" + "=".repeat(60));
    console.log("✅ COMPREHENSIVE DATA SEEDING COMPLETED SUCCESSFULLY!");
    console.log("=".repeat(60));
    console.log("\n📊 Summary:");
    console.log(`   ✓ States: ${states.length}`);
    console.log(`   ✓ Divisions: ${divisions.length}`);
    console.log(`   ✓ Districts: ${districts.length}`);
    console.log(`   ✓ Parliaments: ${parliaments.length}`);
    console.log(`   ✓ Assemblies: ${assemblies.length}`);
    console.log(`   ✓ Blocks: ${blocks.length}`);
    console.log(`   ✓ Panchayats: ${panchayats.length}`);
    console.log(`   ✓ Booths: ${booths.length}`);
    console.log(`   ✓ Villages: ${villages.length}`);
    console.log(`   ✓ Parties: ${parties.length}`);
    console.log(`   ✓ Departments: ${departments.length}`);
    console.log(`   ✓ Work Types: ${workTypes.length}`);
    console.log(`   ✓ Sub Work Types: ${subWorkTypes.length}`);
    console.log(`   ✓ Members: ${members.length}`);
    console.log(`   ✓ Voters: ${voters.length}`);
    console.log(`   ✓ Visitors: ${visitors.length}`);
    console.log(`   ✓ Events: ${events.length}`);
    console.log(`   ✓ Projects: ${projects.length}`);
    console.log("=".repeat(60) + "\n");

    await mongoose.connection.close();
    console.log("✅ Database connection closed.");
    process.exit(0);
  } catch (err) {
    console.error("❌ Error:", err.message);
    console.error(err);
    await mongoose.connection.close();
    process.exit(1);
  }
};

seedComprehensiveData();
