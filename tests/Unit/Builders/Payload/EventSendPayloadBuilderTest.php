<?php
declare(strict_types = 1);

namespace Abrouter\Client\Tests\Unit\Builders\Payload;

use Abrouter\Client\Builders\Payload\EventSendPayloadBuilder;
use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\DTO\EventDTO;
use Abrouter\Client\Tests\Unit\TestCase;

class EventSendPayloadBuilderTest extends TestCase
{
    /**
     * @var EventSendPayloadBuilder $eventSendPayloadBuilder
     */
    private EventSendPayloadBuilder $eventSendPayloadBuilder;
    
    public function setUp(): void
    {
        $this->eventSendPayloadBuilder = $this->getContainer()->make(EventSendPayloadBuilder::class);
    }
    
    public function testPayloadIsCorrect()
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
        
        $payload = $this->eventSendPayloadBuilder->build($eventDTO);
        
        $this->assertInstanceOf(JsonPayload::class, $payload);
        $this->assertEquals($payload->getPayload(), [
            'data' => [
                'type' => 'events',
                'attributes' => [
                    'event' => $eventDTO->getEvent(),
                    'user_id' => $eventDTO->getUserId(),
                    'temporary_user_id' => $eventDTO->getTemporaryUserId(),
                    'tag' => $eventDTO->getTag(),
                    'referrer' => $eventDTO->getReferrer(),
                    'meta' => $eventDTO->getMeta(),
                    'ip' => $eventDTO->getIp()
                ],
                'relationships' => [
                    'owner' => [
                        'data' => [
                            'id'   => $eventDTO->getOwnerId(),
                            'type' => 'users',
                        ],
                    ],
                ]
            ]
        ]);
    }
}
