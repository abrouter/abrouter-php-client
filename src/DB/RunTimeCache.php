<?php

declare(strict_types=1);

namespace Abrouter\Client\DB;

class RunTimeCache
{
    private static array $data = [];

    public static function set(string $key, string $value): void
    {
        self::$data[$key] = $value;
    }

    public static function removeIfExists(string $key): void
    {
        if (!isset(self::$data[$key])) {
            return ;
        }

        unset(self::$data[$key]);
    }


    public static function get($key): ?string
    {
        return self::$data[$key] ?? null;
    }

    public static function flushAll(): void
    {
        self::$data = [];
    }
}
