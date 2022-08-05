<?php

declare(strict_types=1);

namespace Abrouter\Client\DB\Repositories;

use Abrouter\Client\DB\Dictionary\ParallelRunningDictionary;
use Abrouter\Client\DB\RedisConnection;

class ParallelRunningStateRepository
{
    private RedisConnection $redisConnection;

    public function __construct(RedisConnection $redisConnection)
    {
        $this->redisConnection = $redisConnection;
    }

    public function isInitialized(): bool
    {
        $value = $this->redisConnection->getConnection()->get(ParallelRunningDictionary::IS_INITIAZLIED_KEY);
        return $value === ParallelRunningDictionary::IS_INITIAZLIED_TRUE_VALUE;
    }

    public function isReady(): bool
    {
        $value = $this->redisConnection->getConnection()->get(ParallelRunningDictionary::IS_RUNNING_KEY);
        return $value === ParallelRunningDictionary::IS_RUNNING_VALUE_TRUE;
    }
}
