<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\ExperimentsParallelRun;

use Abrouter\Client\DB\Managers\ParallelRunningStateManager;
use Abrouter\Client\DB\RelatedUsersStore;
use Abrouter\Client\DB\Repositories\ParallelRunningStateCachedRepository;

class ParallelRunInitializer
{
    private ParallelRunningStateCachedRepository $parallelRunningStateCachedRepository;

    private ParallelRunningStateManager $parallelRunningStateManager;

    public function __construct(
        ParallelRunningStateCachedRepository $parallelRunningStateCachedRepository,
        ParallelRunningStateManager $parallelRunningStateManager
    ) {
        $this->parallelRunningStateCachedRepository = $parallelRunningStateCachedRepository;
        $this->parallelRunningStateManager = $parallelRunningStateManager;
    }

    public function initializeIfNot(): bool
    {
        //if parallel running ready to serve
        if ($this->parallelRunningStateCachedRepository->isReady()) {
            return true;
        }

        //parallel running was stopped by some reasons. Waiting for the re-enabling
        if ($this->parallelRunningStateCachedRepository->isInitialized()) {
            return false;
        }

        //initialization
        RelatedUsersStore::load([]);

        $this->parallelRunningStateManager->setInitialized();
        $this->parallelRunningStateManager->setReadyToServe();

        return true;
    }
}
