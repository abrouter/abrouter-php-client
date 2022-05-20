<?php

declare(strict_types=1);

namespace Abrouter\Client\Builders\Payload;

use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\DTO\SummarizeEventDTO;

class SummarizePayloadBuilder
{
    /**
     * @param SummarizeEventDTO $summarizeEventDTO
     * @return JsonPayload
     */
    public function build(SummarizeEventDTO $summarizeEventDTO): JsonPayload
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
                    ],
                    'relationships' => [
                        'owner' => [
                            'data' => [
                                'id'   => $summarizeEventDTO->getBaseEventDTO()->getOwnerId(),
                                'type' => 'users',
                            ],
                        ],
                    ]
                ]
            ]
        );
    }
}
