<?php

declare(strict_types=1);

namespace Abrouter\Client\Events\Handlers;

use Abrouter\Client\Contracts\TaskContract;
use Abrouter\Client\Events\HandlerInterface;
use Abrouter\Client\RemoteEntity\Managers\UserBranchManager;
use Abrouter\Client\Services\ExperimentsParallelRun\AddUserToBranchTask;

class AddUserToBranchHandler implements HandlerInterface
{
    private UserBranchManager $userBranchManager;

    public function __construct(UserBranchManager $userBranchManager)
    {
        $this->userBranchManager = $userBranchManager;
    }

    public function handle(TaskContract $taskContract): bool
    {
        if (!($taskContract instanceof AddUserToBranchTask)) {
            return false;
        }

        $this->userBranchManager->addUserToBranch(
            $taskContract->getExperimentId(),
            $taskContract->getExperimentAlias(),
            $taskContract->getBranch(),
            $taskContract->getUserSignature(),
        );

        return true;
    }
}
