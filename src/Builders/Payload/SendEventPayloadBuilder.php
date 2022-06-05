<?php

declare(strict_types=1);

namespace Abrouter\Client\Builders\Payload;

use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\DTO\SummarizeEventDTO;
use Abrouter\Client\DTO\IncrementEventDTO;

class SendEventPayloadBuilder
{
    /**
     * @param IncrementEventDTO $incrementEventDTO
     * @return JsonPayload
     */
    public function buildSendIncrementEventRequest(IncrementEventDTO $incrementEventDTO): JsonPayload
    {
        return new JsonPayload(
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'event' => $incrementEventDTO->getBaseEventDTO()->getEvent(),
                        'user_id' => $incrementEventDTO->getBaseEventDTO()->getUserId(),
                        'temporary_user_id' => $incrementEventDTO->getBaseEventDTO()->getTemporaryUserId(),
                        'tag' => $incrementEventDTO->getBaseEventDTO()->getTag(),
                        'referrer' => $incrementEventDTO->getBaseEventDTO()->getReferrer(),
                        'meta' => $incrementEventDTO->getBaseEventDTO()->getMeta(),
                        'ip' => $incrementEventDTO->getBaseEventDTO()->getIp(),
                        'created_at' => $incrementEventDTO->getBaseEventDTO()->getCreatedAt()
                    ]
                ]
            ]
        );
    }

    public function buildSendSummarizeEventRequest(SummarizeEventDTO $summarizeEventDTO): JsonPayload
    {
        return new JsonPayload(
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'event' => $summarizeEventDTO->getBaseEventDTO()->getEvent(),
                        'value' => $summarizeEventDTO->getValue(),
                        'user_id' => $summarizeEventDTO->getBaseEventDTO()->getUserId(),
                        'temporary_user_id' => $summarizeEventDTO->getBaseEventDTO()->getTemporaryUserId(),
                        'tag' => $summarizeEventDTO->getBaseEventDTO()->getTag(),
                        'referrer' => $summarizeEventDTO->getBaseEventDTO()->getReferrer(),
                        'meta' => $summarizeEventDTO->getBaseEventDTO()->getMeta(),
                        'ip' => $summarizeEventDTO->getBaseEventDTO()->getIp(),
                        'created_at' => $summarizeEventDTO->getBaseEventDTO()->getCreatedAt()
                    ]
                ]
            ]
        );
    }
}
