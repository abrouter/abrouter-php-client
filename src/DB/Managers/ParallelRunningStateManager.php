<?php

declare(strict_types=1);

namespace Abrouter\Client\DB\Managers;

use Abrouter\Client\DB\Dictionary\ParallelRunningDictionary;
use Abrouter\Client\DB\RedisConnection;
use Abrouter\Client\DB\Repositories\ParallelRunningStateCachedRepository;

class ParallelRunningStateManager
{
    private RedisConnection $redisConnection;

    private ParallelRunningStateCachedRepository $parallelRunningStateCachedRepository;

    public function __construct(
        RedisConnection $redisConnection,
        ParallelRunningStateCachedRepository $parallelRunningStateCachedRepository
    ) {
        $this->redisConnection = $redisConnection;
        $this->parallelRunningStateCachedRepository = $parallelRunningStateCachedRepository;
    }

    public function setReadyToServe()
    {
        $this->redisConnection->getConnection()->set(
            ParallelRunningDictionary::IS_RUNNING_KEY,
            ParallelRunningDictionary::IS_RUNNING_VALUE_TRUE
        );
        $this->parallelRunningStateCachedRepository->clearCacheServing();
    }

    public function setStopServing()
    {
        $this->redisConnection->getConnection()->set(
            ParallelRunningDictionary::IS_RUNNING_KEY,
            ParallelRunningDictionary::IS_RUNNING_VALUE_STOPPED
        );
        $this->parallelRunningStateCachedRepository->clearCacheServing();
    }

    public function setInitialized()
    {
        $this->redisConnection->getConnection()->set(
            ParallelRunningDictionary::IS_INITIAZLIED_KEY,
            ParallelRunningDictionary::IS_INITIAZLIED_TRUE_VALUE
        );
        $this->parallelRunningStateCachedRepository->clearCacheInitialized();
    }
}
