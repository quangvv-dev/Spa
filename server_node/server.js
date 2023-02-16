const app = require("./app");
var controller = require('./controllers/TiviBoxController');
const https = require("https");
// const http = require("http");
// const moment = require("moment");
const port = process.env.PORT || 2022;

const fs = require('fs');
const key = fs.readFileSync('/etc/letsencrypt/live/hocvienroyal.adamtech.vn/privkey.pem');
const cert = fs.readFileSync('/etc/letsencrypt/live/hocvienroyal.adamtech.vn/cert.pem');
const ca = fs.readFileSync('/etc/letsencrypt/live/hocvienroyal.adamtech.vn/chain.pem');
const options = {
    key: key,
    cert: cert,
    ca: ca
};
const server = https.createServer(options, app);
// const server = http.createServer(app);
const model = require("./models/TiviBox");
var io = require('socket.io')(server);


app.get('/', (req, res) => {
    res.send("Home page. Server running okay.");
});

app.get('/webhook', function (req, res) {
    let challenge = req.query["hub.challenge"];
    let mode = req.query["hub.mode"];
    if (mode === "subscribe" && req.query['hub.verify_token'] === '0975091435') {
        res.status(200).send(challenge);
    }
    // res.send('Error, wrong validation token');
    res.sendStatus(403);
});

app.post('/webhook', async function (req, res) {
    var entries = req.body.entry;
    res.status(200).send("EVENT_RECEIVED");
    for (var entry of entries) {
        console.log(entry, 'Entry');
        var messaging = entry.messaging;
        if (messaging) {
            for (var message of messaging) {
                console.log(message, 'Message');
                var senderId = message.sender.id;
                var recipientId = message.recipient.id;
                if (message.message) {
                    // controller.sendSocketMessages(message, io);
                    if (message.message.text) {
                        let text = message.message.text;
                        text = text.replace(".", "");
                        text = text.replace("O", "0");
                        // text = text.replace("o", "0");
                        let letr = text.match(/\d+/g);
                        if (!letr) {
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
            console.log(comments, 'COMMENT');
            for (var value of comments) {
                if (value.value.item === 'comment' && value.value.message) {
                    value.type = 'comment';
                    let text2 = value.value.message;
                    text2 = text2.replace(".", "");
                    text2 = text2.replace("O", "0");
                    // text2 = text2.replace("o", "0");
                    let letr = text2.match(/\d+/g);
                    if (!letr) {
                        return false;
                    }
                    letr.every(function (i) {
                        if (i.length === 10) {
                            controller.SetComment(i, value.value.post_id, value.value.message, value.value.from.name);
                            return false;
                        }
                    })
                    // controller.ChatComment(value,io);
                }
                return false;
            }
        }
    }
});


function localeTime() {
    let date = moment.utc().add(7, 'hours').format('YYYY-MM-DD HH:mm:ss');
    // let stillUtc = moment.utc(date).toDate();
    // let localeTime = moment(stillUtc).local().format('YYYY-MM-DD HH:mm:ss');
    return date;
}

server.listen(port, "0.0.0.0", function (error) {
    if (error) console.log("Connect error");
    // const created_at = localeTime();
    console.log("Start server port:", port);
});

