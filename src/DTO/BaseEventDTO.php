<?php

declare(strict_types=1);

namespace Abrouter\Client\DTO;

class BaseEventDTO
{
    /**
     * @var string|null
     */
    private $temporaryUserId;

    /**
     * @var string|null
     */
    private $userId;

    /**
     * @var string
     */
    private $event;

    /**
     * @var string|null
     */
    private ?string $referrer;

    /**
     * @var string|null
     */
    private ?string $tag;

    /**
     * @var array|null
     */
    private ?array $meta;

    /**
     * @var string|null
     */
    private ?string $ip;

    /**
     * @var string|null
     */
    private ?string $created_at;

    /**
     * BaseEventDTO constructor.
     *
     * @param string      $event
     * @param string|null $temporaryUserId
     * @param string|null $userId
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
        $this->temporaryUserId = $temporaryUserId;
        $this->userId = $userId;
        $this->event = $event;
        $this->tag = $tag;
        $this->referrer = $referrer;
        $this->meta = $meta;
        $this->ip = $ip;
        $this->created_at = $created_at;
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
    public function getUserId(): ?string
    {
        return $this->userId;
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
    public function getReferrer(): ?string
    {
        return $this->referrer;
    }

    /**
     * @return string|null
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * @return array|null
     */
    public function getMeta(): ?array
    {
        return $this->meta;
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
        return $this->created_at;
    }
}
