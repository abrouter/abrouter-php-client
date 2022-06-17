<?php

declare(strict_types=1);

namespace Abrouter\Client\DTO;

class EventDTO implements EventDTOInterface
{
    /**
     * @var BaseEventDTO
     */
    private $event;

    /**
     * EventDTO constructor.
     *
     * @param string|null $temporaryUserId
     * @param string|null $userId
     * @param string      $event
     * @param string|null $tag
     * @param string|null $referrer
     * @param array|null  $meta
     * @param string|null $ip
     * @param string|null $created_at
     */
    public function __construct(
        ?string $temporaryUserId = null,
        ?string $userId = null,
        string $event,
        ?string $tag = null,
        ?string $referrer = null,
        ?array $meta = null,
        ?string $ip = null,
        ?string $created_at = null
    ) {
        $this->event = new BaseEventDTO(
            $temporaryUserId,
            $userId,
            $event,
            $tag,
            $referrer,
            $meta,
            $ip,
            $created_at
        );
    }

    public function getBaseEventDTO(): BaseEventDTO
    {
        return $this->event;
    }
}