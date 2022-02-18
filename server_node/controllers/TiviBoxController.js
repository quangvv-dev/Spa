const model = require("../models/TiviBox");
const axios = require('axios');
require('../constants/SettingTivibox');


function userExists(seeding_number, arr) {
    return arr.some(function (el) {
        return el.seeding_number === seeding_number;
    });
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
    console.log(456,FB_ID,page_id);

    model.ListSeeding( function (err, rows) {
        console.log(1234,rows);
    })

    model.CheckFanpage('104351897844467', async function (err, rows) {

        console.log(1234,rows);
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
                    console.log('name',name);

                } catch (err) {
                    console.log('Không Hiển Thị Tên')
                } finally {
                    //create Customer
                    console.log(name, 'Name Customer');
                    const created_at = new Date();
                    model.CheckSource(rows[0].source_id, function (err, row2) {
                        console.log('checksource 123');
                        if (err) {
                            console.log(err);
                        } else {
                            if (row2.length > 0) {
                                let new_position = 0;
                                let array = JSON.parse(row2[0].sale_id);
                                let user_id = array[row2[0].position];
                                let mkt_id = row2[0].user_id;
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
                                            }

                                            model.ListSeeding(function (err, list) {
                                                    let exisits = userExists(phone, list);
                                                    if (exisits == false) {
                                                        model.CheckPhoneAdd(phone, row2[0].id, function (err, vl) {
                                                                if (err) {
                                                                    console.log(err);
                                                                } else {
                                                                    if (vl.length <= 0) {
                                                                        model.CreateCustomer(row2[0].id, name, phone, text, user_id, mkt_id, post_id, FB_ID, duplicate, page_id, 1,  created_at, function (err) {
                                                                            if (err) {
                                                                                console.log(err);
                                                                            } else {
                                                                                console.log('Them KH thanh cong');
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
                const created_at = new Date();
                model.CheckSource(rows[0].source_id, function (err, row2) {
                    if (err) {
                        console.log(err);
                    } else {
                        if (row2.length > 0) {
                            console.log('ton tai source');
                            let new_position = 0;
                            let array = JSON.parse(row2[0].sale_id);
                            let user_id = array[row2[0].position];
                            let mkt_id = row2[0].user_id;
                            if (row2[0].position < array.length - 1 && array.length > 1) {
                                new_position = row2[0].position + 1;
                            }
                            // let splitted = post_id.split("_", 2);
                            let duplicate = 0;

                            model.CheckPhone(phone, function (err, checkPhone) {
                                    if (err) {
                                        console.log(err);
                                    } else {
                                        if (checkPhone.length > 0) {
                                            duplicate = 1;
                                            user_id = checkPhone[0].user_id;
                                        } else {
                                            model.UpdateSource(row2[0].id, new_position, function (err) {
                                                if (err) {
                                                    console.log(err);
                                                } else {
                                                    console.log('Update vi tri source');
                                                }
                                            })
                                        }

                                        model.ListSeeding(function (err, list) {
                                            let exisits = userExists(phone, list);
                                            console.log(exisits, 'LEADING');
                                            if (exisits == false) {
                                                console.log('vao');

                                                model.CheckPhoneAdd(phone, row2[0].id, function (err, vl) {
                                                        if (err) {
                                                            console.log(err);
                                                        } else {
                                                            if (vl.length <= 0) {
                                                                model.CreateCustomer(row2[0].id, sender, phone, text, user_id, mkt_id, splitted[1], 0, 0, 1, 1, created_at, function (err) {
                                                                    if (err) {
                                                                        console.log(err);
                                                                    } else {
                                                                        console.log('Them KH thanh cong');
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
                            );

                        }
                        console.log('KHong co source');
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
                const created_at = new Date();
                model.UpdateLearn(user_id, lecture_id, video_id, time, created_at);
                console.log('done disconnect');
            } else {
                console.log('Không tìm thấy socket_orders');
            }
        }
    })
};
