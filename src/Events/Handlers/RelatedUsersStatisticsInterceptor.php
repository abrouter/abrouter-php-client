<?php

declare(strict_types=1);

namespace Abrouter\Client\Events\Handlers;

use Abrouter\Client\Contracts\TaskContract;
use Abrouter\Client\DB\Managers\RelatedUsersCacheManager;
use Abrouter\Client\DB\RelatedUsersStore;
use Abrouter\Client\DB\Repositories\RelatedUsersCacheRepository;
use Abrouter\Client\Events\HandlerInterface;
use Abrouter\Client\Services\ExperimentsParallelRun\ParallelRunSwitch;
use Abrouter\Client\Services\Statistics\SendEventTask;

class RelatedUsersStatisticsInterceptor implements HandlerInterface
{
    private ParallelRunSwitch $parallelRunSwitch;

    private RelatedUsersStore $relatedUsersStore;

    private RelatedUsersCacheManager $relatedUsersCacheManager;

    private RelatedUsersCacheRepository $relatedUsersCacheRepository;

    public function __construct(
        ParallelRunSwitch $parallelRunSwitch,
        RelatedUsersStore $relatedUsersStore,
        RelatedUsersCacheManager $relatedUsersCacheManager,
        RelatedUsersCacheRepository $relatedUsersCacheRepository
    ) {
        $this->parallelRunSwitch = $parallelRunSwitch;
        $this->relatedUsersStore = $relatedUsersStore;
        $this->relatedUsersCacheManager = $relatedUsersCacheManager;
        $this->relatedUsersCacheRepository = $relatedUsersCacheRepository;
    }

    public function handle(TaskContract $taskContract): bool
    {
        if (!$taskContract instanceof SendEventTask) {
            return false;
        }

        if (!$this->parallelRunSwitch->isEnabled()) {
            return false;
        }

        $userId = $taskContract->getEventDTO()->getBaseEventDTO()->getUserId();
        $temporaryUserId = $taskContract->getEventDTO()->getBaseEventDTO()->getTemporaryUserId();

        if (empty($userId) || empty($temporaryUserId)) {
            return true;
        }

        $this->relatedUsersStore::load($this->relatedUsersCacheRepository->getAll());

        $this->relatedUsersStore->get()->append((string)$userId, (string)$temporaryUserId);

        $this->relatedUsersCacheManager->store(
            $this->relatedUsersStore->get()->getAll()
        );

        return true;
    }
}
