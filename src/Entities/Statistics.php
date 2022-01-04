<?php
declare(strict_types = 1);

namespace Abrouter\Client\Entities;

class Statistics
{
    /**
     * @var string
     */
    private string $event;
    
    public function __construct(string $event)
    {
        $this->event = $event;
    }
    
    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }
}
