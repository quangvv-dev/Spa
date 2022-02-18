var mysql=require('mysql');
require('dotenv').config();
var connection=mysql.createPool({

    connectionLimit: 1000,
    connectTimeout: 60 * 60 * 1000,
    acquireTimeout: 60 * 60 * 1000,
    host:process.env.DB_HOST || 'localhost',
    // user:process.env.DB_USERNAME || 'root',
    user:process.env.DB_USERNAME || 'test-spa',
    password:process.env.DB_PASSWORD || 's7bk0wu8YVC5LWU0',
    // password:process.env.DB_PASSWORD || '',
    database:process.env.DB_DATABASE || 'crm-spa-test'

});
if(connection){
    console.log('login thành công');
    connection.query("SELECT * FROM fanpages WHERE page_id = ? ", '104351897844467', function(err, result) {
        console.log('insert thành công');
        if (err) throw err;
    });

} else {
    console.log('thất bại');
}
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
