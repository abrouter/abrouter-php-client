<?php
declare(strict_types = 1);

namespace Abrouter\Client\Entities;

class Summarize
{
    /**
     * @var string
     */
    private $event;

    /**
     * @var string
     */
    private $value;

    /**
     * @param string $event
     */
    public function __construct(
        string $event,
        string $value
    ) {
        $this->event = $event;
        $this->value = $value;
    }
    
    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        if ($this->event !== null && $this->value !== null) {
            return true;
        } else {
            return false;
        }
    }
}
