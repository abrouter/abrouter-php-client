<?php

declare(strict_types=1);

namespace Abrouter\Client\Builders\Payload;

use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\DTO\EventDTO;

class EventSendPayloadBuilder
{
    /**
     * @param EventDTO $eventDTO
     * @return JsonPayload
     */
    public function build(EventDTO $eventDTO): JsonPayload
    {
        return new JsonPayload(
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'event' => $eventDTO->getEvent(),
                        'temporary_user_id' => $eventDTO->getTemporaryUserId(),
                        'tag' => $eventDTO->getTag(),
                        'referrer' => $eventDTO->getReferrer(),
                        'meta' => $eventDTO->getMeta(),
                        'ip' => $eventDTO->getIp(),
                        'created_at' => $eventDTO->getCreatedAt()
                    ],
                ]
            ]
        );
    }
}
