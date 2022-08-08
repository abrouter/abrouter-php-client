<?php

declare(strict_types=1);

namespace Abrouter\Client\DB;

use Abrouter\Client\Config\Accessors\RedisConfigAccessor;
use Abrouter\Client\Config\RedisConfig;
use Predis\Client;

class RedisConnection
{
    private static ?Client $connection;

    private ?RedisConfig $redisConfig;

    public function __construct(RedisConfigAccessor $redisConfigAccessor)
    {
        $this->redisConfig = $redisConfigAccessor->getRedisConfig();
    }

    public function isReady()
    {
        return $this->redisConfig !== null;
    }

    public function getConnection()
    {
        if (isset(self::$connection)) {
            return self::$connection;
        }

        self::$connection = new Client([
            'scheme' => 'tcp',
            'host'   => $this->redisConfig->getRedisHost(),
            'port'   => $this->redisConfig->getPort(),
            'database' => $this->redisConfig->getDb(),
            'username' => $this->redisConfig->getUsername(),
            'password' => $this->redisConfig->getPassword(),
        ]);

        return self::$connection;
    }
}
