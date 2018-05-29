<?php

namespace App\Services;

use App\Services\CustomPasswordBroker;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use App\Services\CustomTokenRepository;
use Illuminate\Support\Str;

class CustomPasswordBrokerManager extends PasswordBrokerManager {

    protected function resolve($name) {
        $config = $this->getConfig($name);
        if (is_null($config)) {
            throw new \InvalidArgumentException("Password resetter [{$name}] is not defined.");
        }

        return new CustomPasswordBroker(
                $this->createTokenRepository($config)
                , $this->app['auth']->createUserProvider($config['provider'])
        );
    }

    /**
     * Create a token repository instance based on the given configuration.
     *
     * @param  array  $config
     * @return \Illuminate\Auth\Passwords\TokenRepositoryInterface
     */
    protected function createTokenRepository(array $config) {
        $key = $this->app['config']['app.key'];

        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        $connection = isset($config['connection']) ? $config['connection'] : null;

        
        return new CustomTokenRepository(
                $this->app['db']->connection($connection)
                , $this->app['hash']
                , $config['table']
                , $key
                , $config['expire']
                , isset($config['is_api']) ? $config['is_api'] : false
        );
    }

}
