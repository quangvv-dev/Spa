const express = require("express");
const app = express();
const bodyParser = require("body-parser");

app.use(bodyParser.urlencoded({extended: false}));
app.use(bodyParser.json());

app.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Headers', 'Content-Type,X-Requested-With, Authorization, X-CSRF-Token');
    res.header('Access-Control-Allow-Methods', 'GET, POST, PUT, OPTIONS');
    next();
});

module.exports = app;
