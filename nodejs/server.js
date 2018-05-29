require('dotenv').config();

try {
    var redis = require('redis');
    var express = require('express');
    var app = express();
    var server = app.listen(process.env.NODE_PORT);
    var sio = require('socket.io');
    var io = sio.listen(server);
    var helper = null;
    const request = require('request');
//send reset message on server when connected

    var helper = new (require('./helper.js'))(redis);
    var authHelper = new (require('./authHelper'))(helper);
    var socketSynchronizer = new (require('./socketSynchronizer'))
            (helper, authHelper);
    var socketManager = new (require('./socketManager'))
            (io, redis, authHelper, socketSynchronizer);
    socketManager.initialize();

} catch (exception) {
    //throw exception;
    console.log('Exception somewhere ' + exception);
}


