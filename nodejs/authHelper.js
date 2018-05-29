var AuthHelper = function (helper) {

    var self = this;
    var helper = helper;
    var redisClient = helper.getRedisClient();
    var request = require('request');
    var redisKeys = {
        refreshToken: "authRefreshToken",
        bearerHeader: "authBearerHeader"
    }
    var nodeUserCredentials = {
        username: process.env.SHOCAS_AUTH_EMAIL,
        password: process.env.SHOCAS_AUTH_PASSWORD
    }

    this.authenticateUser = function (data) {
        return new Promise(function (resolve, reject) {
            request.get({
                uri: process.env.API_URL + '/user/self',
                headers: {
                    'Authorization': data.authorization,
                }
            }, function (err, resp, body) {
                if (err) {
                    reject(err);
                } else {
                    switch (resp.statusCode) {
                        case 401:
                            helper.log('User not authorized');
                            reject(err);
                            break;
                        case 200:
                            resolve(JSON.parse(body).user);
                            break;
                        default:
                            helper.log('UserAuth wrong code ' + resp.statusCode);
                            reject(err);
                            break;
                    }
                }
            });
        });
    }

    this.authorizeNode = function () {
        return new Promise(function (resolve, reject) {
            request.post({
                uri: process.env.API_URL + '/auth',
                form: {email: nodeUserCredentials.username,
                    password: nodeUserCredentials.password}
            }, function (err, resp, body) {
                if (err) {
                    reject(err);
                } else {
                    switch (resp.statusCode) {
                        case 400:
                        case 401:
                            helper.log("Access token receiving failed"
                                    //+ nodeUserCredentials.username 
                                    + process.env.SHOCAS_AUTH_EMAIL);
                            reject(err);
                            break;
                        case 200:
                            var body = JSON.parse(body);
                            var client = helper.getRedisClient();
                            var accessToken = body.access_token;
                            var refreshToken = body.refresh_token;
                            //helper.log('token ' + accessToken);
                            if (typeof accessToken === 'undefined' ||
                                    typeof refreshToken === 'undefined') {
                                helper.log(body);
                                reject(err);
                            }
                            var authHeader = self.makeAuthHeader(accessToken);
                            client.set(self.getAuthHeaderKey(), authHeader);
                            client.set(self.getRefreshTokenKey(), refreshToken);
                            helper.log("Access token received");
                            resolve(body);
                            break;
                        default:
                            helper.log('Access token wrong code');
                            reject(err);
                            break;
                    }
                }
            });
        });
    }

    this.getAuthHeader = function () {
        return new Promise(function (resolve, reject) {
            redisClient.get(redisKeys.bearerHeader, function (err, reply) {
                //helper.log('rediskeyrep: ' + reply);

                if (reply === null || typeof reply === 'undefined') {
                    self.authorizeNode().then(function (body) {
                        resolve(self.makeAuthHeader(body.access_token));
                    }, function () {
                        reject();
                    });
                } else {
                    resolve(reply);
                }
            });
        });
    }

    this.makeAuthHeader = function (acccessToken) {
        return 'Bearer ' + acccessToken;
    }

    this.getAuthHeaderKey = function () {
        return redisKeys.bearerHeader;

    }
    this.getRefreshTokenKey = function () {
        return redisKeys.refreshToken;
    }
}

module.exports = AuthHelper;

