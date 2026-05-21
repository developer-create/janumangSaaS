const path = require("path");
require("dotenv").config({ path: path.resolve(__dirname, "../.env") });
const mongoose = require("mongoose");
const User = require("../src/models/userModel");
const Role = require("../src/models/roleModel");
const Permission = require("../src/models/permissionModel");
const Tenant = require("../src/models/tenantModel");

const seedRolesAndAdmin = async () => {
  try {
    console.log("🔗 Connecting to MongoDB...");
    await mongoose.connect(process.env.MONGO_URI);
    console.log("✅ Connected to MongoDB");

    // Create or get default tenant
    console.log("\n🏢 Creating/Getting Default Tenant...");
    let tenant = await Tenant.findOne({ name: "Default Tenant" });
    
    if (!tenant) {
      tenant = await Tenant.create({
        name: "Default Tenant",
        slug: "default-tenant",
        isActive: true,
      });
      console.log("✅ Default tenant created");
    } else {
      console.log("⏭️  Default tenant already exists");
    }

    // Get all permissions
    const allPermissions = await Permission.find();
    console.log(`\n📋 Found ${allPermissions.length} permissions`);

    // Create Superadmin Role
    console.log("\n📝 Creating Superadmin Role...");
    let superadminRole = await Role.findOne({ name: "superadmin" });
    
    if (!superadminRole) {
      superadminRole = await Role.create({
        name: "superadmin",
        displayName: "Super Administrator",
        description: "System Super Administrator with full access",
        permissions: allPermissions.map(p => p._id),
        tenantId: tenant._id,
        isActive: true,
      });
      console.log("✅ Superadmin role created");
    } else {
      console.log("⏭️  Superadmin role already exists");
    }

    // Create Admin Role
    console.log("\n📝 Creating Admin Role...");
    let adminRole = await Role.findOne({ name: "admin" });
    
    if (!adminRole) {
      adminRole = await Role.create({
        name: "admin",
        displayName: "Administrator",
        description: "Administrator with most permissions",
        permissions: allPermissions.map(p => p._id),
        tenantId: tenant._id,
        isActive: true,
      });
      console.log("✅ Admin role created");
    } else {
      console.log("⏭️  Admin role already exists");
    }

    // Create User Role
    console.log("\n📝 Creating User Role...");
    let userRole = await Role.findOne({ name: "user" });
    
    if (!userRole) {
      userRole = await Role.create({
        name: "user",
        displayName: "User",
        description: "Regular user with limited permissions",
        permissions: allPermissions.filter(p => p.name.startsWith("view_")).map(p => p._id),
        tenantId: tenant._id,
        isActive: true,
      });
      console.log("✅ User role created");
    } else {
      console.log("⏭️  User role already exists");
    }

    // Create Super Admin User
    console.log("\n👤 Creating Super Admin User...");
    const superAdminEmail = "superadmin@janumang.com";
    const superAdminPassword = "Admin@123456";

    let superAdminUser = await User.findOne({ email: superAdminEmail });
    
    if (superAdminUser) {
      superAdminUser.password = superAdminPassword;
      superAdminUser.role = superadminRole._id;
      superAdminUser.level = "system_admin";
      superAdminUser.userType = "superadmin";
      superAdminUser.tenantId = undefined; // NO tenantId for platform admins
      superAdminUser.isActive = true;
      await superAdminUser.save();
      console.log("✅ Super Admin user updated");
    } else {
      superAdminUser = await User.create({
        name: "System Super Admin",
        email: superAdminEmail,
        password: superAdminPassword,
        role: superadminRole._id,
        level: "system_admin",
        userType: "superadmin",
        // NO tenantId for platform admins
        isActive: true,
      });
      console.log("✅ Super Admin user created");
    }

    // Create Admin User
    console.log("\n👤 Creating Admin User...");
    const adminEmail = "admin@janumang.com";
    const adminPassword = "Admin@123456";

    let adminUser = await User.findOne({ email: adminEmail });
    
    if (adminUser) {
      adminUser.password = adminPassword;
      adminUser.role = adminRole._id;
      adminUser.level = "tenant_admin";
      adminUser.userType = "admin";
      adminUser.tenantId = tenant._id;
      adminUser.isActive = true;
      await adminUser.save();
      console.log("✅ Admin user updated");
    } else {
      adminUser = await User.create({
        name: "Administrator",
        email: adminEmail,
        password: adminPassword,
        role: adminRole._id,
        level: "tenant_admin",
        userType: "admin",
        tenantId: tenant._id,
        isActive: true,
      });
      console.log("✅ Admin user created");
    }

    // Create Test User
    console.log("\n👤 Creating Test User...");
    const testEmail = "user@janumang.com";
    const testPassword = "User@123456";

    let testUser = await User.findOne({ email: testEmail });
    
    if (testUser) {
      testUser.password = testPassword;
      testUser.role = userRole._id;
      testUser.level = "regularUser";
      testUser.userType = "user";
      testUser.tenantId = tenant._id;
      testUser.isActive = true;
      await testUser.save();
      console.log("✅ Test user updated");
    } else {
      testUser = await User.create({
        name: "Test User",
        email: testEmail,
        password: testPassword,
        role: userRole._id,
        level: "regularUser",
        userType: "user",
        tenantId: tenant._id,
        isActive: true,
      });
      console.log("✅ Test user created");
    }

    console.log("\n" + "=".repeat(60));
    console.log("✅ SEEDING COMPLETED SUCCESSFULLY!");
    console.log("=".repeat(60));
    console.log("\n📧 LOGIN CREDENTIALS:\n");
    console.log("1️⃣  SUPER ADMIN:");
    console.log(`   Email:    ${superAdminEmail}`);
    console.log(`   Password: ${superAdminPassword}`);
    console.log(`   Role:     Superadmin\n`);
    
    console.log("2️⃣  ADMIN:");
    console.log(`   Email:    ${adminEmail}`);
    console.log(`   Password: ${adminPassword}`);
    console.log(`   Role:     Admin\n`);
    
    console.log("3️⃣  USER:");
    console.log(`   Email:    ${testEmail}`);
    console.log(`   Password: ${testPassword}`);
    console.log(`   Role:     User\n`);
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

seedRolesAndAdmin();
