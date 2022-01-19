<?php
declare(strict_types =1);

namespace Abrouter\Client\DTO;

class EventDTO
{
    /**
     * @var string
     */
    private $ownerId;

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
    private $referrer;
    
    /**
     * @var string|null
     */
    private $tag;
    
    /**
     * @var array|null
     */
    private $meta;
    
    /**
     * @var string|null
     */
    private $ip;
    
    /**
     * EventDTO constructor.
     *
     * @param string    $ownerId
     * @param string|null $temporaryUserId
     * @param string|null $userId
     * @param string $event
     * @param string|null $tag
     * @param string|null $referrer
     * @param array|null  $meta
     * @param string|null $ip
     */
    public function __construct(
        string $ownerId,
        ?string $temporaryUserId,
        ?string $userId,
        string $event,
        ?string $tag,
        ?string $referrer,
        ?array $meta,
        ?string $ip
    ) {
        $this->ownerId = $ownerId;
        $this->temporaryUserId = $temporaryUserId;
        $this->userId = $userId;
        $this->event = $event;
        $this->tag = $tag;
        $this->referrer = $referrer;
        $this->meta = $meta;
        $this->ip = $ip;
    }
    
    /**
     * @return int
     */
    public function getOwnerId(): string
    {
        return $this->ownerId;
    }

    /**
     * @return string
     */
    public function getTemporaryUserId(): ?string
    {
        return $this->temporaryUserId;
    }
    
    /**
     * @return string
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
     * @return string
     */
    public function getReferrer(): ?string
    {
        return $this->referrer;
    }
    
    /**
     * @return string
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }
    
    /**
     * @return array
     */
    public function getMeta(): ?array
    {
        return $this->meta;
    }
    
    /**
     * @return string
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }
}