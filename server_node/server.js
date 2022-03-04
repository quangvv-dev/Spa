const app = require("./app");
var controller = require('./controllers/TiviBoxController');
const https = require("https");
// const http = require("http");
const port = process.env.PORT || 2022;

const fs = require('fs');
const key = fs.readFileSync('/etc/letsencrypt/live/testspa.adamtech.vn/privkey.pem');
const cert = fs.readFileSync('/etc/letsencrypt/live/testspa.adamtech.vn/cert.pem');
const ca = fs.readFileSync('/etc/letsencrypt/live/testspa.adamtech.vn/chain.pem');
const options = {
    key: key,
    cert: cert,
    ca: ca
};
const server = https.createServer(options, app);
// const server = http.createServer(app);
const model = require("./models/TiviBox");


app.get('/', (req, res) => {
    res.send("Home page. Server running okay.");
});

app.get('/webhook', function (req, res) {
    if (req.query['hub.verify_token'] === '0975091435') {
        res.send(req.query['hub.challenge']);
    }
    res.send('Error, wrong validation token');
});

app.post('/webhook', function (req, res) {
    var entries = req.body.entry;
    res.sendStatus(200);
    for (var entry of entries) {
        console.log(entry, 'DU LIEU FACEBOOK');

        var messaging = entry.messaging;
        if (messaging) {
            for (var message of messaging) {
                console.log(message, 'Message');
                var senderId = message.sender.id;
                var recipientId = message.recipient.id;
                if (message.message) {
                    if (message.message.text) {
                        let text = message.message.text;
                        // text = text.replace(".", "");
                        text = text.replace("O", "0");
                        text = text.replace("o", "0");
                        console.log('Noi dung tin nhan', text); // In tin nhắn người dùng
                        let letr = text.match(/\d+/g);
                        if (!letr){
                            return false;
                        }
                        letr.every(function (i) {
                            if (i.length === 10) {
                                controller.SetCustomers(i, recipientId, message.message.text, senderId);
                                return false;
                            }
                        })
                    }
                }
            }
        } else {

            var comments = entry.changes;
            console.log(comments, 'COMMENT LAN 2');
            for (var value of comments) {
                console.log(value, 'comentt');

                if (value.value.item === 'comment') {
                    let text2 = value.value.message;
                    // text2 = text2.replace(".", "");
                    text2 = text2.replace("O", "0");
                    text2 = text2.replace("o", "0");
                    let letr = text2.match(/\d+/g);
                    if (!letr){
                        return false;
                    }
                    letr.every(function (i) {
                        if (i.length === 10) {
                            controller.SetComment(i, value.value.post_id, value.value.message, value.value.from.name);
                            return false;
                        }
                    })
                }
            }
        }
    }
});

server.listen(port, "0.0.0.0", function (error) {
    if (error) console.log("Connect error");
    // const created_at = new Date();
    console.log("Start server port:", port);
});
