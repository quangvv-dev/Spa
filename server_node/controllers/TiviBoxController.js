const model = require("../models/TiviBox");
const axios = require('axios');
require('../constants/SettingTivibox');
const moment = require("moment");

function userExists(seeding_number, arr) {
    return arr.some(function (el) {
        return el.seeding_number === seeding_number;
    });
}

function localeTime() {
    let date = moment.utc().add(7, 'hours').format('YYYY-MM-DD HH:mm:ss');
    // let stillUtc = moment.utc(date).toDate();
    // let localeTime = moment(stillUtc).local().format('YYYY-MM-DD HH:mm:ss');
    return date;
}

/**
 * Nhập liệu khách hàng từ tin nhắn
 *
 * @param phone
 * @param recipientId
 * @param text
 * @param senderId
 * @constructor
 */
exports.SetCustomers = (phone, recipientId, text, senderId) => {
    let FB_ID = senderId;
    let page_id = recipientId;
    model.CheckFanpage(recipientId, async function (err, rows) {
        if (err) {
            console.log(err, 'err');
        } else {
            if (rows.length > 0) {
                //call api get name with PSID
                let url = 'https://graph.facebook.com/v10.0/' + senderId + '/?access_token=' + rows[0].access_token;
                var name = 'Người dùng Facebook';
                try {
                    await axios.get(url).then(response => {
                        name = response.data.last_name + ' ' + response.data.first_name;
                    });
                } catch (err) {
                    console.log('Không Hiển Thị Tên')
                } finally {
                    //create Customer
                    const created_at = localeTime();
                    model.CheckSource(rows[0].source_id, function (err, row2) {
                        if (err) {
                            console.log(err);
                        } else {
                            if (row2.length > 0) {
                                let new_position = 0;
                                let array = JSON.parse(row2[0].sale_id);
                                let user_id = array[row2[0].position];
                                let mkt_id = row2[0].mkt_id;
                                let branch_id = row2[0].branch_id;
                                if (row2[0].position < array.length - 1 && array.length > 1) {
                                    new_position = row2[0].position + 1;
                                }
                                let duplicate = 0;
                                let post_id = 0;

                                model.CheckPhone(phone, function (err, checkPhone) {
                                        if (err) {
                                            console.log(err);
                                        } else {
                                            if (checkPhone.length > 0) {
                                                duplicate = 1;
                                                user_id = checkPhone[0].user_id;
                                                console.log('Sale cũ', checkPhone[0], duplicate);
                                            } else {
                                                model.UpdateSource(row2[0].id, new_position, function (err) {
                                                    if (err) {
                                                        console.log(err);
                                                    }
                                                })
                                                model.ListSeeding(function (err, list) {
                                                        let exisits = userExists(phone, list);
                                                        if (exisits == false) {

                                                            model.CheckPhoneAdd(phone, row2[0].id, function (err, vl) {
                                                                    if (err) {
                                                                        console.log(err);
                                                                    } else {
                                                                        if (vl.length <= 0) {
                                                                            model.CreateCustomer(row2[0].id, name, phone, text, user_id, mkt_id, post_id, FB_ID, duplicate, page_id, 1, 1, branch_id, created_at, function (err, customer) {
                                                                                if (err) {
                                                                                    console.log(err);
                                                                                } else {
                                                                                    customer = JSON.parse(JSON.stringify(customer));
                                                                                    model.UpdateCodeCustomer(customer.insertId);
                                                                                    let arr_category_id = JSON.parse(row2[0].category_id);

                                                                                    for (const val of arr_category_id) {
                                                                                        model.CreateCustomerGroup(customer.insertId, val, created_at, branch_id);
                                                                                    }
                                                                                }
                                                                            })
                                                                        }
                                                                    }
                                                                }
                                                            );
                                                        }

                                                    }
                                                );
                                            }

                                        }
                                    }
                                );

                            }
                        }
                    })
                    //end create
                }
//end call
            }
        }
    })
};

/**
 * Nhập liệu khách hàng từ comment bài viết
 *
 * @param phone
 * @param post_id
 * @param text
 * @param sender
 * @constructor
 */
exports.SetComment = (phone, post_id, text, sender) => {

    var splitted = post_id.split("_", 2);
    model.CheckPost(splitted[1], function (err, rows) {
        if (err) {
            console.log(err, 'err');
        } else {
            if (rows.length > 0) {
                const created_at = localeTime();
                console.log(' Time zone Asian', created_at);
                model.CheckSource(rows[0].source_id, function (err, row2) {
                    if (err) {
                        console.log(err);
                    } else {
                        if (row2.length > 0) {
                            let new_position = 0;
                            let array = JSON.parse(row2[0].sale_id);
                            let user_id = array[row2[0].position];
                            let branch_id = row2[0].branch_id;
                            let mkt_id = row2[0].mkt_id;
                            if (row2[0].position < array.length - 1 && array.length > 1) {
                                new_position = row2[0].position + 1;
                            }
                            // let splitted = post_id.split("_", 2);
                            // let duplicate = 0;

                            model.CheckPhone(phone, function (err, checkPhone) {
                                    if (err) {
                                        console.log(err, 'CHECK PHONE LOG');
                                    } else {
                                        if (checkPhone.length <= 0) {
                                            model.UpdateSource(row2[0].id, new_position, function (err) {
                                                if (err) {
                                                    console.log(err);
                                                } else {
                                                    console.log('Update vi tri source');
                                                }
                                            })

                                            model.ListSeeding(function (err, list) {
                                                if (err) {
                                                    console.log('Check seeding number', err);
                                                }
                                                let exisits = userExists(phone, list);
                                                if (exisits == false) {
                                                    model.CheckPhoneAdd(phone, row2[0].id, function (err, vl) {
                                                            if (err) {
                                                                console.log(err,);
                                                            } else {
                                                                if (vl.length <= 0) {
                                                                    model.CreateCustomer(row2[0].id, sender, phone, text, user_id, mkt_id, splitted[1], 0, 0, 0, 1, 1, branch_id, created_at, function (err, customer) {
                                                                        if (err) {
                                                                            console.log(err);
                                                                        } else {
                                                                            customer = JSON.parse(JSON.stringify(customer));
                                                                            model.UpdateCodeCustomer(customer.insertId);
                                                                            let arr_category_id = JSON.parse(row2[0].category_id);

                                                                            for (const val of arr_category_id) {
                                                                                model.CreateCustomerGroup(customer.insertId, val, created_at, branch_id);
                                                                            }
                                                                        }
                                                                    })
                                                                }
                                                            }
                                                        }
                                                    );
                                                }
                                            });
                                        }
                                    }
                                }
                            );

                        }
                    }
                })
            } else {
                console.log('Khong tim thay post thoa man')
            }
        }
    })
};

exports.UpdateTimeOrderOff = (socket_id, io) => {
    model.CheckOnline(socket_id, function (err, rows) {
        if (err) {
            console.log(err);
        } else {
            console.log(rows.length);
            if (rows.length > 0) {
                const now = Math.round(new Date().getTime() / 1000);
                const before = Math.round(rows[0].created_at.getTime() / 1000);
                const time = parseInt(now) - parseInt(before);
                const lecture_id = rows[0].lecture_id;
                const user_id = rows[0].user_id;
                const video_id = rows[0].video_id;
                const created_at = localeTime();
                model.UpdateLearn(user_id, lecture_id, video_id, time, created_at);
                console.log('done disconnect');
            } else {
                console.log('Không tìm thấy socket_orders');
            }
        }
    })

};

exports.sendSocketMessages = (message, io) => {
    //     socket.removeAllListeners();
    io.emit(message.recipient.id, message);
};
exports.sendSocketComment = (page_id, message, io) => {
    //     socket.removeAllListeners();
    io.emit(page_id, message);
};

exports.ChatComment = (value,io) => {
    model.CheckFanpage(value.value.from.id, async function (err, fanpage) {
        if (fanpage.length < 1) {
            let splitted = value.value.post_id.split("_", 2);
            const page_id = splitted[0], post_id = splitted[1];
            const FB_ID = value.value.from.id;
            const fb_name = value.value.from.name;
            const created_at = localeTime();
            await model.CheckExistsComment(page_id, post_id, FB_ID, function (err, comment) {
                // model.CheckExistsComment(page_id,post_id,value.value.from.id).then(comment=>{
                let data_content = [{
                    // created_time: new Date(value.value.created_time).toISOString(),
                    created_time: new Date().toISOString(),
                    message: value.value.message,
                    comment_id: value.value.comment_id,
                    parent_id: value.value.parent_id,
                }]
                console.log(comment,comment.length,'check length comment');
                if (comment.length <1) { //trường hợp thêm mới
                    let content = JSON.stringify(data_content);
                    model.CreateComment(page_id, post_id, FB_ID, fb_name, value.value.message, content, created_at, function (err, comment) {
                    });
                    value.check_create =1;
                } else { //trường hợp đã tồn tại
                    let data = comment[0];
                    let content_old = JSON.parse(data.content);
                    content_old.push(data_content[0]);
                    let content = JSON.stringify(content_old);
                    model.UpdateComment(data.id, value.value.message, content);
                    value.check_create =2;
                }
                console.log('Chuẩn bị bắn socket');
                sendSocketComment(page_id,value, io);
                console.log('Đã bắn socket');

                return 0;
            });
        } else {
            return 0;
        }
    });
}

// function  replace(number) {
//     return parseInt(number.toString().replace('n',''));
//
// }
// value.type = 'comment';
// controller.sendSocketComment(splitted[0],value, io);

