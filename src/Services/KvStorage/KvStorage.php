<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\KvStorage;

use Abrouter\Client\Contracts\KvStorageContract;
use Abrouter\Client\DB\RedisConnection;

class KvStorage implements KvStorageContract
{
    private RedisConnection $redisConnection;

    public function __construct(RedisConnection $redisConnection)
    {
        $this->redisConnection = $redisConnection;
    }

    public function put(string $key, string $value, int $expiresInSeconds = 0): void
    {
        if ($expiresInSeconds === 0) {
            $this->redisConnection->getConnection()->set($key, $value);
            return ;
        }

        $this->redisConnection->getConnection()->set($key, $value, 'EX', $expiresInSeconds);
    }

    public function remove(string $key): void
    {
        $this->redisConnection->getConnection()->del($key);
    }

    public function get(string $key)
    {
        return $this->redisConnection->getConnection()->get($key);
    }
}
