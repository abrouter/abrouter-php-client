<?php

declare(strict_types=1);

namespace Abrouter\Client\Builders\Payload;

use Abrouter\Client\DTO\EventDTO;
use Abrouter\Client\Entities\JsonPayload;

class SendEventPayloadBuilder
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
                        'event' => $eventDTO->getBaseEventDTO()->getEvent(),
                        'user_id' => $eventDTO->getBaseEventDTO()->getUserId(),
                        'temporary_user_id' => $eventDTO->getBaseEventDTO()->getTemporaryUserId(),
                        'value' => method_exists($eventDTO, 'getValue') ? $eventDTO->getValue() : null,
                        'tag' => $eventDTO->getBaseEventDTO()->getTag(),
                        'referrer' => $eventDTO->getBaseEventDTO()->getReferrer(),
                        'meta' => $eventDTO->getBaseEventDTO()->getMeta(),
                        'ip' => $eventDTO->getBaseEventDTO()->getIp(),
                        'created_at' => $eventDTO->getBaseEventDTO()->getCreatedAt()
                    ]
                ]
            ]
        );
    }
}
