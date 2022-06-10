<?php

declare(strict_types=1);

namespace Abrouter\Client\Config;

use Abrouter\Client\Contracts\KvStorageContract;

class Config
{
    /**
     * @var string $token
     */
    private string $token;

    /**
     * @var string $host
     */
    private string $host;

    /**
     * @var ParallelRunConfig|null
     */
    private ?ParallelRunConfig $parallelRunConfig = null;

    /**
     * @var KvStorageContract|null
     */
    private ?KvStorageContract $kvStorageConfig = null;

    private ?RedisConfig $redisConfig = null;

    public function __construct(
        string $token,
        string $host
    ) {
        $this->token = $token;
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return KvStorageContract|null
     */
    public function getKvStorage(): ?KvStorageContract
    {
        return $this->kvStorageConfig;
    }

    /**
     * @return ParallelRunConfig|null
     */
    public function getParallelRunConfig(): ?ParallelRunConfig
    {
        return $this->parallelRunConfig;
    }

    public function setParallelRunConfig(ParallelRunConfig $parallelRunConfig): self
    {
        $this->parallelRunConfig = $parallelRunConfig;
        return $this;
    }

    public function setKvStorageConfig(KvStorageContract $parallelRunConfig): self
    {
        $this->kvStorageConfig = $parallelRunConfig;
        return $this;
    }

    public function setRedisConfig(RedisConfig $redisConfig): self
    {
        $this->redisConfig = $redisConfig;
        return $this;
    }

    /**
     * @return RedisConfig
     */
    public function getRedisConfig(): ?RedisConfig
    {
        return $this->redisConfig;
    }
}
