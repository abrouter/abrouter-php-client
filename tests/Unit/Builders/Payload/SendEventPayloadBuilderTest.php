<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Builders\Payload;

use Abrouter\Client\Builders\Payload\SendEventPayloadBuilder;
use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\DTO\EventDTO;
use Abrouter\Client\Tests\Unit\TestCase;

class SendEventPayloadBuilderTest extends TestCase
{
    /** @var SendEventPayloadBuilder $sendEventPayloadBuilder */
    private SendEventPayloadBuilder $sendEventPayloadBuilder;

    /** @return void */
    public function setUp(): void
    {
        $this->sendEventPayloadBuilder = $this->getContainer()
                ->make(SendEventPayloadBuilder::class);
    }

    /**
     * @return void
     */
    public function testPayloadIsCorrect()
    {
        $date = (new \DateTime())->format('Y-m-d');
        $eventDTO = new EventDTO(
            'temporary_user_' . uniqid(),
            'user_' . uniqid(),
            'new_event',
            'new_tag',
            'abrouter',
            [],
            '255.255.255.255',
            $date
        );
        $payload = $this->sendEventPayloadBuilder->build($eventDTO);
        $this->assertInstanceOf(JsonPayload::class, $payload);
        $this->assertEquals($payload->getPayload(), [
            'data' => [
                'type' => 'events',
                'attributes' => [
                    'event' => $eventDTO->getBaseEventDTO()->getEvent(),
                    'user_id' => $eventDTO->getBaseEventDTO()->getUserId(),
                    'temporary_user_id' => $eventDTO->getBaseEventDTO()->getTemporaryUserId(),
                    'value' => null,
                    'tag' => $eventDTO->getBaseEventDTO()->getTag(),
                    'referrer' => $eventDTO->getBaseEventDTO()->getReferrer(),
                    'meta' => $eventDTO->getBaseEventDTO()->getMeta(),
                    'ip' => $eventDTO->getBaseEventDTO()->getIp(),
                    'created_at' => $eventDTO->getBaseEventDTO()->getCreatedAt()
                ]
            ]
        ]);
    }
}
