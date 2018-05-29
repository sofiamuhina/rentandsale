<?php

namespace App\Services;

use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class CustomTokenRepository extends DatabaseTokenRepository {
    
    protected $isApi;


    /**
     * Create a new token repository instance.
     *
     * @param  \Illuminate\Database\ConnectionInterface  $connection
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @param  string  $table
     * @param  string  $hashKey
     * @param  int  $expires
     * @return void
     */
    public function __construct(ConnectionInterface $connection, HasherContract $hasher,
                                $table, $hashKey, $expires = 60, $isApi = false)
    {
        $this->table = $table;
        $this->hasher = $hasher;
        $this->hashKey = $hashKey;
        $this->expires = $expires * 60;
        $this->connection = $connection;
        $this->isApi = $isApi;
    }


    /**
     * Create a new token for the user.
     *
     * @return string
     */
    public function createNewToken() {
        //throw new \Exception($this->isApi ? 'hello' : 'goodbye');
        if ($this->isApi) {
            return Str::random(9);
        }
        return hash_hmac('sha256', Str::random(40), $this->hashKey);
    }

}
