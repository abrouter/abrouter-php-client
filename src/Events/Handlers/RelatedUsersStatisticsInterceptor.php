<?php

declare(strict_types=1);

namespace Abrouter\Client\Events\Handlers;

use Abrouter\Client\Contracts\TaskContract;
use Abrouter\Client\DB\RelatedUsersStore;
use Abrouter\Client\Events\HandlerInterface;
use Abrouter\Client\Services\ExperimentsParallelRun\ParallelRunSwitch;
use Abrouter\Client\Services\Statistics\SendEventTask;

class RelatedUsersStatisticsInterceptor implements HandlerInterface
{
    private ParallelRunSwitch $parallelRunSwitch;

    private RelatedUsersStore $relatedUsersStore;

    public function __construct(
        ParallelRunSwitch $parallelRunSwitch,
        RelatedUsersStore $relatedUsersStore
    ) {
        $this->parallelRunSwitch = $parallelRunSwitch;
        $this->relatedUsersStore = $relatedUsersStore;
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

        $this->relatedUsersStore->get()->append($userId, $temporaryUserId);

        return true;
    }
}
