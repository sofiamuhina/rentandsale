var socketSycnronizer = function (helper, authHelper) {
    var helper = helper;
    var authHelper = authHelper;
    var request = require('request');

    this.socketConnected = function (userId, socketId) {
        return new Promise(function (resolve, reject) {
            authHelper.getAuthHeader().then(function (authHeader) {
                var uri = process.env.API_URL + '/user/' + userId + '/socket/' + socketId;
                //helper.log('uri + header ' + uri + ' ' + authHeader);
                request.post({
                    uri: uri,
                    headers: {
                        'Authorization': authHeader,
                    }
                }, function (err, resp, body) {
                    if (err) {
                        reject(err);
                    } else {
                        switch (resp.statusCode) {
                            case 200:
                                body = JSON.parse(body);
                                helper.log('Conn sync '
                                        + socketId + ' user ' + userId);
                                resolve(body);
                                break;
                            default:
                                helper.log('Socket conn not synchronized '
                                        + resp.statusCode + ' '
                                        + socketId + ' user ' + userId);
                                reject(err);
                                break;
                        }
                    }
                });
            }, function (err) {
                helper.log('conn conn failed');
            });
        });
    }

    this.socketDisconnected = function (socketId) {
        return new Promise(function (resolve, reject) {
            authHelper.getAuthHeader().then(function (authHeader) {
                request.delete({
                    uri: process.env.API_URL + '/socket/' + socketId,
                    headers: {
                        'Authorization': authHeader,
                    }
                }, function (err, resp, body) {
                    if (err) {
                        reject(err);
                    } else {
                        switch (resp.statusCode) {
                            case 200:
                                body = JSON.parse(body);
                                helper.log('Disconn sync '
                                        + socketId //+ ' user ' 
                                        //+ userId
                                        );
                                resolve(body);
                                break;
                            default:
                                helper.log('Socket disconn not synchronized '
                                        + resp.statusCode);
                                reject(err);
                                break;
                        }
                    }
                });
            }, function () {
                helper.log('conn discon failed');
            });
        });
    }

    this.reset = function () {
        return new Promise(function (resolve, reject) {
            authHelper.getAuthHeader().then(function (authHeader) {
                request.delete({
                    uri: process.env.API_URL + '/socket/',
                    headers: {
                        'Authorization': authHeader,
                    }
                }, function (err, resp, body) {
                    if (err) {
                        reject(err);
                    } else {
                        switch (resp.statusCode) {
                            case 200:
                                body = JSON.parse(body);
                                helper.log('Socket reset success');
                                resolve(body);
                                break;
                            default:
                                helper.log('Socket reset failed '
                                        + resp.statusCode);
                                reject(err);
                                break;
                        }
                    }
                });
            }, function () {
                helper.log('Reset failed');
            });
        });
    }
}

module.exports = socketSycnronizer;