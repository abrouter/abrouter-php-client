<?php

declare(strict_types=1);

namespace Abrouter\Client\DB\Managers;

use Abrouter\Client\Config\Accessors\KvStorageConfigAccessor;
use Abrouter\Client\DB\Dictionary\ParallelRunningDictionary;
use Abrouter\Client\DB\Repositories\ParallelRunningStateCachedRepository;

class ParallelRunningStateManager
{
    private ParallelRunningStateCachedRepository $parallelRunningStateCachedRepository;
    private KvStorageConfigAccessor $kvStorageConfigAccessor;

    public function __construct(
        KvStorageConfigAccessor $kvStorageConfigAccessor,
        ParallelRunningStateCachedRepository $parallelRunningStateCachedRepository
    ) {
        $this->kvStorageConfigAccessor = $kvStorageConfigAccessor;
        $this->parallelRunningStateCachedRepository = $parallelRunningStateCachedRepository;
    }

    public function setReadyToServe()
    {
        $this->kvStorageConfigAccessor->getKvStorage()->put(
            ParallelRunningDictionary::IS_RUNNING_KEY,
            ParallelRunningDictionary::IS_RUNNING_VALUE_TRUE
        );
        $this->parallelRunningStateCachedRepository->clearCacheServing();
    }

    public function setStopServing()
    {
        $this->kvStorageConfigAccessor->getKvStorage()->put(
            ParallelRunningDictionary::IS_RUNNING_KEY,
            ParallelRunningDictionary::IS_RUNNING_VALUE_STOPPED
        );
        $this->parallelRunningStateCachedRepository->clearCacheServing();
    }

    public function setInitialized()
    {
        $this->kvStorageConfigAccessor->getKvStorage()->put(
            ParallelRunningDictionary::IS_INITIAZLIED_KEY,
            ParallelRunningDictionary::IS_INITIAZLIED_TRUE_VALUE
        );
        $this->parallelRunningStateCachedRepository->clearCacheInitialized();
    }
}
