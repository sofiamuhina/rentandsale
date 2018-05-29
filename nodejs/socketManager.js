var socketManager = function (io, redis, authHelper, socketSynchronizer) {
    var io = io;
    var redis = redis;
    var authHelper = authHelper;
    var socketSynchronizer = socketSynchronizer;

    this.initialize = function () {
        socketSynchronizer.reset().then(function () {
            manage();
            console.log('Online');
        }, function () {
            console.log('Offline');
        });
    }

    function manage() {
        io.on('connection', function (socket) {
            var helper = new (require('./helper.js'))(redis);

            socket.auth = false;
            socket.on('authenticate', function (data) {
                authHelper.authenticateUser(data).then(function (user) {
                    onSuccess(user.id);
                    /*helper.log("Authenticated socket " + socket.id
                     + " user " + user.id);*/
                }, function (err) {
                    helper.log(err);
                    onFail();
                });
            });

            setTimeout(function () {
                if (!socket.auth) {
                    onFail();
                }
            }, 2000);

            function onFail() {
                socket.emit('authenticated', {isAuthenticated: false});
                helper.log("Disconnecting socket ", socket.id);
                socket.disconnect('unauthorized');
            }

            function onSuccess(userId) {
                socket.emit('authenticated', {isAuthenticated: true});
                socket.auth = true;
                setRedisListeners(userId);

                //authHelper.authorizeNode();
            }

            function setRedisListeners(userId) {
                helper.log("+client");
                var redisClient = helper.getRedisClient();
                var uChanName = 'user/' + userId;

                redisClient.on('error', function (error) {
                    helper.log('Redis client error ' + error + ' channel '
                            + uChanName);
                });

                socket.on('disconnect', function () {
                    helper.log(socket.id + " disconnected " + uChanName);
                    redisClient.quit();
                    socketSynchronizer.socketDisconnected(socket.id).then(function () {
                        //blabla
                    }, function () {
                        //blabla
                    });
                });

                redisClient.subscribe(uChanName);
                redisClient.subscribe('message');

                redisClient.on('message', function (chan, data) {
                    data = JSON.parse(data);
                    var channel = data.channel;
                    var data = data.data;
                    if (channel === uChanName && data.socket_id === socket.id) {
                        socket.disconnect();
                    }

                    helper.log("new mess: " + data + " channel " + channel
                            + ' to: ' + uChanName);
                    socket.emit(channel, data);
                });

                socketSynchronizer.socketConnected(userId, socket.id).then(function () {
                    //blabla
                }, function () {
                    //blabla
                });
            }
        });
        io.on('error', (error) => {
            console.log('socket.io error occured ' + error);
        });
    }
}


module.exports = socketManager