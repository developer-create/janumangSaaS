const bcrypt = require('bcryptjs');
const mongoose = require('mongoose');

async function run() {
  await mongoose.connect('mongodb+srv://developer:Hh1q2w3e4r5t6y7u8i9o0p@cluster0.8ehw8jn.mongodb.net/janumang_dev');
  const users = mongoose.connection.db.collection('users');
  const hash = await bcrypt.hash('123456', 10);
  
  await users.updateOne({email: 'developer@akalptechnomediasolutions.com'}, { $set: {password: hash} });
  await users.updateOne({email: 'superadmin@janumang.com'}, { $set: {password: hash} });
  
  console.log('Passwords reset successfully');
  await mongoose.disconnect();
}
run();
