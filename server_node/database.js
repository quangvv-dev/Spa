var mysql=require('mysql');
require('dotenv').config();
var connection=mysql.createPool({

    host:process.env.DB_HOST || 'localhost',
    user:process.env.DB_USERNAME || 'root',
    // user:process.env.DB_USERNAME || 'test-spa',
    // password:process.env.DB_PASSWORD || 's7bk0wu8YVC5LWU0',
    password:process.env.DB_PASSWORD || 'bITt@wO2uR3*',
    database:process.env.DB_DATABASE || 'crm-spa-test'

});
connection.getConnection(function(err, connection) {
    if(err){
        console.log(err);
    }else {
        console.log('passed')
    }
    // ...
});
module.exports=connection;

// var mysql=require('mysql');
// require('dotenv').config();
// var connection=mysql.createPool({
//
//     host:process.env.DB_HOST || 'localhost',
//     user:process.env.DB_USERNAME || 'app-tamly.yez.vn',
//     password:process.env.DB_PASSWORD || 'Vin@123$',
//     database:process.env.DB_DATABASE || 'app-tamly.yez.vn'
//
// });
// module.exports=connection;