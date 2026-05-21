const { spawn } = require('child_process');
const os = require('os');

/**
 * Start MongoDB server if not already running
 */
function startMongoDB() {
  return new Promise((resolve, reject) => {
    // Check if MongoDB is already running
    const net = require('net');
    const client = new net.Socket();

    client.connect(27017, 'localhost', () => {
      // MongoDB is already running
      console.log('✅ MongoDB is already running on port 27017');
      client.destroy();
      resolve();
    });

    client.on('error', () => {
      // MongoDB is not running, start it
      console.log('🔄 Starting MongoDB...');
      
      try {
        let mongoProcess;
        
        if (os.platform() === 'win32') {
          // Windows
          mongoProcess = spawn('mongod', [], {
            detached: true,
            stdio: 'ignore',
            shell: true
          });
        } else if (os.platform() === 'darwin') {
          // macOS
          mongoProcess = spawn('mongod', [], {
            detached: true,
            stdio: 'ignore'
          });
        } else {
          // Linux
          mongoProcess = spawn('mongod', [], {
            detached: true,
            stdio: 'ignore'
          });
        }

        // Unref the process so it doesn't keep the parent alive
        mongoProcess.unref();

        // Wait for MongoDB to start
        setTimeout(() => {
          console.log('✅ MongoDB started successfully');
          resolve();
        }, 2000);

      } catch (error) {
        console.error('❌ Failed to start MongoDB:', error.message);
        reject(error);
      }
    });
  });
}

module.exports = { startMongoDB };
