<?php

declare(strict_types=1);

namespace Abrouter\Client\DB\Repositories;

use Abrouter\Client\Config\Accessors\KvStorageConfigAccessor;
use Abrouter\Client\DB\Dictionary\ParallelRunningDictionary;

class ParallelRunningStateRepository
{
    private KvStorageConfigAccessor $kvStorage;

    public function __construct(KvStorageConfigAccessor $kvStorageConfigAccessor)
    {
        $this->kvStorage = $kvStorageConfigAccessor;
    }

    public function isInitialized(): bool
    {
        $value = $this->kvStorage->getKvStorage()->get(ParallelRunningDictionary::IS_INITIAZLIED_KEY);
        return $value === ParallelRunningDictionary::IS_INITIAZLIED_TRUE_VALUE;
    }

    public function isReady(): bool
    {
        $value = $this->kvStorage->getKvStorage()->get(ParallelRunningDictionary::IS_RUNNING_KEY);
        return $value === ParallelRunningDictionary::IS_RUNNING_VALUE_TRUE;
    }
}
