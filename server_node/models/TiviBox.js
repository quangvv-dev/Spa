var db = require('../database');

var TiviBox = {
    /**
     * Check tồn tại lịch sử học
     * @param user_id
     * @param lecture_id
     * @param callback
     * @constructor
     */
    ListSeeding: function (callback) {
        return db.query("SELECT * FROM seeding_numbers", callback);
    },

    CheckPhone: function (phone, callback) {
        return db.query("SELECT * FROM customers WHERE phone = ?", [phone], callback);
    },

    CheckPhoneAdd: function (phone, source_id, callback) {
        return db.query("SELECT * FROM customers WHERE phone = ? AND  source_id = ?", [phone, source_id], callback);
    },

    CheckPost: function (post_id, callback) {
        return db.query("SELECT * FROM fanpage_posts WHERE post_id = ? AND used = ?", [post_id, 1], callback);
    },

    CheckFanpage: function (page_id, callback) {
        return db.query("SELECT * FROM fanpages WHERE page_id = ? ", [page_id], callback);
    },

    CheckSource: function (source_id, callback) {
        return db.query("SELECT * FROM sources WHERE id = ? ", [source_id], callback);
    },

    CreateCustomer: function (source_fb, name, phone, message, user_id, mkt_id, post_id, FB_ID, duplicate, page_id, status, expired_time_boolean, branch_id, created_at, callback) {
        return db.query("INSERT INTO customers (source_id,source_fb,full_name,phone,gender,message,telesales_id,mkt_id,status_id,fb_name,post_id,FB_ID, page_id,branch_id,created_at,updated_at) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [18,source_fb, name, phone,0, message, user_id, mkt_id,4,name, post_id, FB_ID, page_id, branch_id, created_at, created_at], callback);
    },

    CreateCustomerGroup: function (customer_id, category_id, created_at,branch_id) {
        return db.query("INSERT INTO customer_groups (customer_id,category_id,created_at,updated_at,branch_id) VALUES(?,?,?,?,?)", [customer_id, category_id, created_at, created_at,branch_id]);
    },
    UpdateCodeCustomer: function (customer_id) {
        let code = 'KH'+customer_id;
        return db.query("UPDATE customers SET account_code = ? WHERE id = ?", [ code, customer_id]);
    },








    UpdateSource: function (source_id, position, callback) {
        return db.query("UPDATE sources SET position = ? WHERE id = ?", [position, source_id], callback);
    },

    DeleteOnline: function (socket_id, callback) {
        return db.query("DELETE FROM onlines WHERE socket_id = ?", [socket_id], callback);
    },
};
module.exports = TiviBox;
