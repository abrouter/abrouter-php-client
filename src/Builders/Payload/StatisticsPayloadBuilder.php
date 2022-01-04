<?php
declare(strict_types = 1);

namespace Abrouter\Client\Builders\Payload;

use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\Services\DTO\EventDTO;

class StatisticsPayloadBuilder
{
    public function build(EventDTO $eventDTO): JsonPayload
    {
        return new JsonPayload([
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'event' => $eventDTO->getEvent(),
                        'user_id' => $eventDTO->getUserId(),
                        'temporary_user_id' => $eventDTO->getTemporaryUserId(),
                        'tag' => $eventDTO->getTag(),
                        'referrer' => $eventDTO->getReferrer(),
                        'meta' => $eventDTO->getMeta(),
                        'ip' => $eventDTO->getIp()
                    ],
                    'relationships' => [
                        'owner' => [
                            'data' => [
                                'id'   => $eventDTO->getOwnerId(),
                                'type' => 'users',
                            ],
                        ],
                    ]
                ],
        ]);
    }
}
