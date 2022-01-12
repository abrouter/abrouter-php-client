<?php
declare(strict_types = 1);

namespace Abrouter\Client\Tests\Unit\Entities;

use Abrouter\Client\Entities\SentEvent;
use Abrouter\Client\DTO\EventDTO;
use Abrouter\Client\Tests\Unit\TestCase;

class SentEventTest extends TestCase
{
    public function testStatistics()
    {
        $eventDTO = new EventDTO(
            'owner_' . uniqid(),
            'temporary_user_' . uniqid(),
            'user_' . uniqid(),
            'new_event',
            'new_tag',
            'abrouter',
            [],
            '255.255.255.255'
        );
        
        $sentEvent = new SentEvent(
            $eventDTO->getUserId(),
            $eventDTO->getEvent(),
            $eventDTO->getTag(),
            $eventDTO->getReferrer(),
            $eventDTO->getMeta(),
            $eventDTO->getIp()
        );
        $this->assertEquals($sentEvent->getUserId(), $eventDTO->getUserId());
        $this->assertEquals($sentEvent->getEvent(), $eventDTO->getEvent());
        $this->assertEquals($sentEvent->getTag(), $eventDTO->getTag());
        $this->assertEquals($sentEvent->getReferrer(), $eventDTO->getReferrer());
        $this->assertEquals($sentEvent->getMeta(), $eventDTO->getMeta());
        $this->assertEquals($sentEvent->getIp(), $eventDTO->getIp());
    }
}
