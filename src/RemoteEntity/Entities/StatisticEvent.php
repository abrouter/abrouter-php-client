<?php

declare(strict_types=1);

namespace Abrouter\Client\RemoteEntity\Entities;

class StatisticEvent
{
    private string $event;

    private ?string $userId;

    private ?string $temporaryUserId;

    private ?string $value;

    private ?string $tag;

    private ?string $referrer;

    private ?string $ip;

    private ?string $createdAt;

    public function __construct(
        string $event,
        ?string $userId,
        ?string $temporaryUserId,
        ?string $value,
        ?string $tag,
        ?string $referrer,
        ?string $ip,
        ?string $createdAt
    ) {
        $this->event = $event;
        $this->userId = $userId;
        $this->temporaryUserId = $temporaryUserId;
        $this->value = $value;
        $this->tag = $tag;
        $this->referrer = $referrer;
        $this->ip = $ip;
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @return string|null
     */
    public function getUserId(): ?string
    {
        return $this->userId;
    }

    /**
     * @return string|null
     */
    public function getTemporaryUserId(): ?string
    {
        return $this->temporaryUserId;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @return string|null
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * @return string|null
     */
    public function getReferrer(): ?string
    {
        return $this->referrer;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }
}
