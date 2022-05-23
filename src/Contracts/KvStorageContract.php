<?php

declare(strict_types=1);

namespace Abrouter\Client\Contracts;

interface KvStorageContract
{
    public function put(string $key, string $value, int $expiresInSeconds = 0): void;
    public function remove(string $key): void;
    public function get(string $key);
}
