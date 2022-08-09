<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\ExperimentsParallelRun;

use Abrouter\Client\DB\Managers\ParallelRunningStateManager;
use Abrouter\Client\DB\RelatedUsersStore;
use Abrouter\Client\DB\Repositories\ParallelRunningStateCachedRepository;
use Abrouter\Client\DB\Repositories\RelatedUsersCacheRepository;

class ParallelRunInitializer
{
    private ParallelRunningStateCachedRepository $parallelRunningStateCachedRepository;

    private ParallelRunningStateManager $parallelRunningStateManager;

    private RelatedUsersCacheRepository $relatedUsersCacheRepository;

    public function __construct(
        ParallelRunningStateCachedRepository $parallelRunningStateCachedRepository,
        ParallelRunningStateManager $parallelRunningStateManager,
        RelatedUsersCacheRepository $relatedUsersCacheRepository
    ) {
        $this->parallelRunningStateCachedRepository = $parallelRunningStateCachedRepository;
        $this->parallelRunningStateManager = $parallelRunningStateManager;
        $this->relatedUsersCacheRepository = $relatedUsersCacheRepository;
    }

    public function initializeIfNot(): bool
    {
        if (!RelatedUsersStore::isLoaded()) {
            //initialization related users
            RelatedUsersStore::load($this->relatedUsersCacheRepository->getAll());
        }

        //if parallel running ready to serve
        if ($this->parallelRunningStateCachedRepository->isReady()) {
            return true;
        }

        //parallel running was stopped by some reasons. Waiting for the re-enabling
        if ($this->parallelRunningStateCachedRepository->isInitialized()) {
            return false;
        }

        $this->parallelRunningStateManager->setInitialized();
        $this->parallelRunningStateManager->setReadyToServe();

        return true;
    }
}
