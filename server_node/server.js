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

app.post('/webhook',async function (req, res) {
    var entries = req.body.entry;
    res.sendStatus(200);
    for (var entry of entries) {
        var messaging = entry.messaging;
        if (messaging) {
            for (var message of messaging) {
                console.log(message, 'Message');
                if (message.message) {
                    controller.sendSocketMessages(message, io);
                }
            }
        } else {

            var comments = entry.changes;
            console.log(comments, 'COMMENT');
            for (var value of comments) {
                if (value.value.item === 'comment' && value.value.message) {
                    value.type = 'comment';
                    controller.ChatComment(value,io);
                }
                return false;
            }
        }
    }
});


function localeTime(){
    let date =  moment.utc().add(7, 'hours').format('YYYY-MM-DD HH:mm:ss');
    // let stillUtc = moment.utc(date).toDate();
    // let localeTime = moment(stillUtc).local().format('YYYY-MM-DD HH:mm:ss');
    return date;
}

server.listen(port, "0.0.0.0", function (error) {
    if (error) console.log("Connect error");
    // const created_at = localeTime();
    console.log("Start server port:", port);
});

