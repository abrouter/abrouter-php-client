<?php
declare(strict_types = 1);

namespace Abrouter\Client\Tests\Unit\Entities;

use Abrouter\Client\Entities\SendEvent;
use Abrouter\Client\DTO\EventDTO;
use Abrouter\Client\Tests\Unit\TestCase;

class SendEventTest extends TestCase
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
        
        $sendEvent = new SendEvent(
            $eventDTO->getUserId(),
            $eventDTO->getEvent(),
            $eventDTO->getTag(),
            $eventDTO->getReferrer(),
            $eventDTO->getMeta(),
            $eventDTO->getIp()
        );
        $this->assertEquals($sendEvent->getUserId(), $eventDTO->getUserId());
        $this->assertEquals($sendEvent->getEvent(), $eventDTO->getEvent());
        $this->assertEquals($sendEvent->getTag(), $eventDTO->getTag());
        $this->assertEquals($sendEvent->getReferrer(), $eventDTO->getReferrer());
        $this->assertEquals($sendEvent->getMeta(), $eventDTO->getMeta());
        $this->assertEquals($sendEvent->getIp(), $eventDTO->getIp());
    }
}
