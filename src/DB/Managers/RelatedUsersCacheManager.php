<?php

declare(strict_types=1);

namespace Abrouter\Client\DB\Managers;

use Abrouter\Client\Config\Accessors\KvStorageConfigAccessor;
use Abrouter\Client\DB\Dictionary\ParallelRunningDictionary;
use Abrouter\Client\Services\KvStorage\KvStorage;

class RelatedUsersCacheManager
{
    private const EXPIRES = 3600 * 24 * 180;

    private KvStorageConfigAccessor $kvStorage;

    public function __construct(
        KvStorageConfigAccessor $kvStorage
    ) {
        $this->kvStorage = $kvStorage;
    }

    public function store(array $relatedUsers): void
    {
        $this
            ->kvStorage
            ->getKvStorage()
            ->put(
                ParallelRunningDictionary::RELATED_USERS_KEY,
                json_encode($relatedUsers),
                self::EXPIRES
            );
    }
}
