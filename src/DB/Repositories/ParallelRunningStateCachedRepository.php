<?php

declare(strict_types=1);

namespace Abrouter\Client\DB\Repositories;

use Abrouter\Client\DB\Dictionary\ParallelRunningDictionary;
use Abrouter\Client\DB\RunTimeCache;

class ParallelRunningStateCachedRepository
{
    private ParallelRunningStateRepository $parallelRunningStateRepository;

    public function __construct(ParallelRunningStateRepository $parallelRunningStateRepository)
    {
        $this->parallelRunningStateRepository = $parallelRunningStateRepository;
    }

    public function isReady(): bool
    {
        $cached = RunTimeCache::get(ParallelRunningDictionary::IS_RUNNING_KEY);
        if ($cached !== null) {
            return $cached === 'true';
        }

        $isReady = $this->parallelRunningStateRepository->isReady();
        RunTimeCache::set(
            ParallelRunningDictionary::IS_RUNNING_KEY,
            $isReady ? 'true' : 'false'
        );

        return $isReady;
    }

    public function isInitialized()
    {
        $cached = RunTimeCache::get(ParallelRunningDictionary::IS_INITIAZLIED_KEY);
        if ($cached !== null) {
            return $cached === 'true';
        }

        $value = $this->parallelRunningStateRepository->isInitialized();
        RunTimeCache::set(
            ParallelRunningDictionary::IS_INITIAZLIED_KEY,
            $value ? 'true' : 'false'
        );

        return $value;
    }

    public function clearCacheInitialized()
    {
        RunTimeCache::removeIfExists(ParallelRunningDictionary::IS_INITIAZLIED_KEY);
    }

    public function clearCacheServing()
    {
        RunTimeCache::removeIfExists(ParallelRunningDictionary::IS_RUNNING_KEY);
    }
}
