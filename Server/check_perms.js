const mongoose = require('mongoose');
const Permission = require('./src/models/permissionModel');

mongoose.connect('mongodb://localhost:27017/janumang').then(async () => {
    const count = await Permission.countDocuments();
    console.log("Total permissions in DB:", count);
    
    if (count > 0) {
        const sample = await Permission.findOne();
        console.log("Sample permission:", sample);
    }
    
    mongoose.disconnect();
});
