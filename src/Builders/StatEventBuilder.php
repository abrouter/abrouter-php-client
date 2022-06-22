<?php

declare(strict_types=1);

namespace Abrouter\Client\Builders;

use Abrouter\Client\DTO\BaseEventDTO;
use Abrouter\Client\DTO\EventDTOInterface;
use Abrouter\Client\DTO\IncrementalEventDTO;
use Abrouter\Client\DTO\SummarizeEventDTO;

class StatEventBuilder
{
    private const EVENT_TYPE_INCREMENTAL = 1;
    private const EVENT_TYPE_SUMMARIZE = 2;

    private ?string $temporaryUserId = null;
    private ?string $userId = null;
    private ?string $event = null;
    private ?string $referrer = null;
    private ?array $meta = null;
    private ?string $tag = null;
    private ?string $ip = null;
    private ?string $createdAt = null;
    private ?string $value = null;

    private int $type = self::EVENT_TYPE_INCREMENTAL;

    public function setTemporaryUserId(string $temporaryUserId): self
    {
        $this->temporaryUserId = $temporaryUserId;
        return $this;
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function event(string $event): self
    {
        $this->event = $event;
        return $this;
    }

    public function setReferrer(string $referrer): self
    {
        $this->referrer = $referrer;
        return $this;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;
        return $this;
    }

    public function setMeta(array $meta): self
    {
        $this->meta = $meta;
        return $this;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setValue($value): self
    {
        $this->value = (string) $value;
        return $this;
    }

    public function incremental(): self
    {
        $this->type = self::EVENT_TYPE_INCREMENTAL;
        return $this;
    }

    public function summarize(): self
    {
        $this->type = self::EVENT_TYPE_SUMMARIZE;
        return $this;
    }

    public function build(): EventDTOInterface
    {
        $baseEventDTO = new BaseEventDTO(
            $this->temporaryUserId,
            $this->userId,
            $this->event,
            $this->tag,
            $this->referrer,
            $this->meta,
            $this->ip,
            $this->createdAt
        );

        if ($this->type === self::EVENT_TYPE_INCREMENTAL) {
            return new IncrementalEventDTO($baseEventDTO);
        }

        return new SummarizeEventDTO($this->value, $baseEventDTO);
    }
}
