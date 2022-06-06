<?php

declare(strict_types=1);

namespace Abrouter\Client\Config\Accessors;

use Abrouter\Client\Config\RedisConfig;

class RedisConfigAccessor extends BaseAccessor
{
    public function getRedisConfig(): ?RedisConfig
    {
        return $this->getConfig()->getRedisConfig();
    }
}
