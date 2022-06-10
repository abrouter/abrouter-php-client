<?php

declare(strict_types=1);

namespace Abrouter\Client\Config;

/**
 * Using Redis
 */
class RedisConfig
{
    private string $redisHost;

    private int $port;

    private string $username;

    private string $db;

    private string $password;

    public function __construct(string $redisHost, int $port, string $username, string $db, string $password)
    {
        $this->redisHost = $redisHost;
        $this->port = $port;
        $this->username = $username;
        $this->db = $db;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getRedisHost(): string
    {
        return $this->redisHost;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getDb(): string
    {
        return $this->db;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
