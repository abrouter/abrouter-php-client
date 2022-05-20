<?php

declare(strict_types=1);

namespace Abrouter\Client\Builders\Payload;

use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\DTO\IncrementEventDTO;

class IncrementPayloadBuilder
{
    /**
     * @param IncrementEventDTO $incrementEventDTO
     * @return JsonPayload
     */
    public function build(IncrementEventDTO $incrementEventDTO): JsonPayload
    {
        return new JsonPayload(
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'event' => $incrementEventDTO->getBaseEventDTO()->getEvent(),
                        'value' => '',
                        'user_id' => $incrementEventDTO->getBaseEventDTO()->getUserId(),
                        'temporary_user_id' => $incrementEventDTO->getBaseEventDTO()->getTemporaryUserId(),
                        'tag' => $incrementEventDTO->getBaseEventDTO()->getTag(),
                        'referrer' => $incrementEventDTO->getBaseEventDTO()->getReferrer(),
                        'meta' => $incrementEventDTO->getBaseEventDTO()->getMeta(),
                        'ip' => $incrementEventDTO->getBaseEventDTO()->getIp(),
                        'created_at' => $incrementEventDTO->getBaseEventDTO()->getCreatedAt()
                    ],
                    'relationships' => [
                        'owner' => [
                            'data' => [
                                'id'   => $incrementEventDTO->getBaseEventDTO()->getOwnerId(),
                                'type' => 'users',
                            ],
                        ],
                    ]
                ]
            ]
        );
    }
}
