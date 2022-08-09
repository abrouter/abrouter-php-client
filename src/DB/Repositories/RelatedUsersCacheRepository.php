<?php

declare(strict_types=1);

namespace Abrouter\Client\DB\Repositories;

use Abrouter\Client\Config\Accessors\KvStorageConfigAccessor;
use Abrouter\Client\DB\Dictionary\ParallelRunningDictionary;
use Abrouter\Client\Services\KvStorage\KvStorage;

class RelatedUsersCacheRepository
{
    private KvStorageConfigAccessor $kvStorage;

    public function __construct(
        KvStorageConfigAccessor $kvStorage
    ) {
        $this->kvStorage = $kvStorage;
    }

    public function getAll(): array
    {
        $json = $this->kvStorage->getKvStorage()->get(ParallelRunningDictionary::RELATED_USERS_KEY);
        return $json === null ? [] : json_decode($json, true);
    }
}
