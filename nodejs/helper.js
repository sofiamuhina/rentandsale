var Helper = function (redis) {
    var redis = redis;
    var redisClient = null;

    this.getRedisClient = function () {
        if (redisClient === null) {
            redisClient = redis.createClient();
        }
        return redisClient;
    }

    this.getDate = function () {
        var date = new Date();
        return date.toLocaleString();
    }

    this.log = function (message) {
        console.log(this.getDate() + ' ' + message);
    }

    this.getApiUrl = function () {
        return process.env.API_URL;
    }
}

module.exports = Helper;