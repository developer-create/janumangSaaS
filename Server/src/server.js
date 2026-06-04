const connectDB = require("./config/db");
const { startSubscriptionCron } = require("./services/subscriptionCron");
const app = require("./app");
const { spawn } = require('child_process');
const net = require('net');

// Configuration
const validateEnv = require("./config/configValidation");
validateEnv();

// Handle Uncaught Exceptions
process.on("uncaughtException", (err) => {
  console.log("UNCAUGHT EXCEPTION! 💥 Shutting down...");
  console.log(err.name, err.message);
  process.exit(1);
});

// Function to check if MongoDB is running
function checkMongoDB() {
  return new Promise((resolve) => {
    const client = new net.Socket();
    client.connect(27017, 'localhost', () => {
      client.destroy();
      resolve(true);
    });
    client.on('error', () => {
      resolve(false);
    });
  });
}

// Function to start MongoDB
function startMongoDB() {
  return new Promise((resolve) => {
    console.log('🔄 Starting MongoDB...');
    try {
      const mongoProcess = spawn('mongod', [], {
        detached: true,
        stdio: 'ignore',
        shell: true
      });
      mongoProcess.unref();
      setTimeout(() => {
        console.log('✅ MongoDB started');
        resolve();
      }, 2000);
    } catch (error) {
      console.error('❌ Could not start MongoDB:', error.message);
      resolve();
    }
  });
}

// Initialize
(async () => {
  // Only try to start local MongoDB in development
  if (process.env.NODE_ENV !== 'production') {
    const isRunning = await checkMongoDB();
    if (!isRunning) {
      await startMongoDB();
    } else {
      console.log('✅ MongoDB is already running locally');
    }
  } else {
    console.log('✅ Production Mode: Skipping local MongoDB check');
  }
  
  // Connect Database
  connectDB();
  
  // Kick off background jobs
  startSubscriptionCron();
})();

// Kick off background jobs (trial + subscription expiry cron)
startSubscriptionCron();

const PORT = process.env.PORT || 5000;

const server = app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});

// Handle Unhandled Rejections
process.on("unhandledRejection", (err) => {
  console.log("UNHANDLED REJECTION! 💥 Shutting down...");
  console.log(err.name, err.message);
  server.close(() => {
    process.exit(1);
  });
});
