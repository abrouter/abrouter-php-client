<?php

declare(strict_types=1);

namespace Abrouter\Client\Config;

class KvStorageConfig
{
    /**
     * @var string
     */
    private string $kvStorageHost;

    /**
     * @var int
     */
    private $kvStoragePort;

    /**
     * @var string
     */
    private $kvStoragePassword;

    /**
     * @var string
     */
    private $kvStorageDatabase;

    public function __construct(
        string $kvStorageHost,
        int $kvStoragePort,
        string $kvStoragePassword,
        string $kvStorageDatabase
    ) {
        $this->kvStorageHost = $kvStorageHost;
        $this->kvStoragePort = $kvStoragePort;
        $this->kvStoragePassword = $kvStoragePassword;
        $this->kvStorageDatabase = $kvStorageDatabase;
    }

    /**
     * @return string
     */
    public function getKvStorageHost(): string
    {
        return $this->kvStorageHost;
    }

    /**
     * @return int
     */
    public function getKvStoragePort(): int
    {
        return $this->kvStoragePort;
    }

    /**
     * @return string
     */
    public function getKvStoragePassword(): string
    {
        return $this->kvStoragePassword;
    }

    /**
     * @return string
     */
    public function getKvStorageDatabase(): string
    {
        return $this->kvStorageDatabase;
    }
}
