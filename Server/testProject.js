const mongoose = require("mongoose");
const Project = require("./src/models/projectModel");
require("dotenv").config();

async function test() {
  try {
    await mongoose.connect(process.env.MONGO_URI || "mongodb://localhost:27017/janumang");
    const p = new Project({
      district: "Test",
      block: "Test",
      department: "Test",
      workName: "Test Work",
      projectCost: 100,
      proposalEstimate: 100,
    });
    await p.save();
    console.log("Success");
  } catch (err) {
    console.error("ERROR CAUGHT:");
    console.error(err);
  } finally {
    mongoose.disconnect();
  }
}
test();
