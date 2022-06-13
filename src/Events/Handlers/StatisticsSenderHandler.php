<?php

declare(strict_types=1);

namespace Abrouter\Client\Events\Handlers;

use Abrouter\Client\Contracts\TaskContract;
use Abrouter\Client\Events\HandlerInterface;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\Exceptions\SendEventRequestException;
use Abrouter\Client\Services\Statistics\SendEventService;
use Abrouter\Client\Services\Statistics\SendIncrementEventTask;
use Abrouter\Client\Services\Statistics\SendSummarizableEventTask;

class StatisticsSenderHandler implements HandlerInterface
{
    private SendEventService $sendEventService;

    public function __construct(SendEventService $sendEventService)
    {
        $this->sendEventService = $sendEventService;
    }

    /**
     * @param TaskContract $taskContract
     * @return bool
     * @throws InvalidJsonApiResponseException
     * @throws SendEventRequestException
     */
    public function handle(TaskContract $taskContract): bool
    {
        if (
            !($taskContract instanceof SendSummarizableEventTask) &&
            !($taskContract instanceof SendIncrementEventTask)
        ) {
            return false;
        }

        if ($taskContract instanceof SendSummarizableEventTask) {
            return $this->sendEventService->sendSummarizableEvent(
                $taskContract->getSummarizableEventDTO()
            )->isSuccessful();
        } else {
            return $this->sendEventService->sendIncrementEvent(
                $taskContract->getIncrementEventDTO()
            )->isSuccessful();
        }
    }
}
