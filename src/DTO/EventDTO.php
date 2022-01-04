<?php
declare(strict_types =1);

namespace Abrouter\Client\DTO;

class EventDTO
{
    /**
     * @var int
     */
    private $ownerId;

    /**
     * @var string
     */
    private $temporaryUserId;
    
    /**
     * @var string
     */
    private $userId;
    
    /**
     * @var string
     */
    private $event;
    
    /**
     * @var string
     */
    private $referrer;
    
    /**
     * @var string
     */
    private $tag;
    
    /**
     * @var array
     */
    private $meta;
    
    /**
     * @var string
     */
    private $ip;
    
    /**
     * @var string
     */
    private $countryCode;
    
    /**
     * EventDTO constructor.
     *
     * @param int    $ownerId
     * @param string $temporaryUserId
     * @param string $userId
     * @param string $event
     * @param string $tag
     * @param string $referrer
     * @param array  $meta
     * @param string $ip
     */
    public function __construct(
        int $ownerId,
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
    public function getOwnerId(): int
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
