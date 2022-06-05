<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Builders\Payload;

use Abrouter\Client\Builders\Payload\SendEventPayloadBuilder;
use Abrouter\Client\DTO\BaseEventDTO;
use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\DTO\IncrementEventDTO;
use Abrouter\Client\Tests\Unit\TestCase;

class IncrementPayloadBuilderTest extends TestCase
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
        $incrementEventDTO = new IncrementEventDTO(new BaseEventDTO(
            'temporary_user_' . uniqid(),
            'user_' . uniqid(),
            'new_event',
            'new_tag',
            'abrouter',
            [],
            '255.255.255.255',
            $date
        ));
        $payload = $this->sendEventPayloadBuilder->buildSendIncrementEventRequest($incrementEventDTO);
        $this->assertInstanceOf(JsonPayload::class, $payload);
        $this->assertEquals($payload->getPayload(), [
            'data' => [
                'type' => 'events',
                'attributes' => [
                    'event' => $incrementEventDTO->getBaseEventDTO()->getEvent(),
                    'user_id' => $incrementEventDTO->getBaseEventDTO()->getUserId(),
                    'temporary_user_id' => $incrementEventDTO->getBaseEventDTO()->getTemporaryUserId(),
                    'tag' => $incrementEventDTO->getBaseEventDTO()->getTag(),
                    'referrer' => $incrementEventDTO->getBaseEventDTO()->getReferrer(),
                    'meta' => $incrementEventDTO->getBaseEventDTO()->getMeta(),
                    'ip' => $incrementEventDTO->getBaseEventDTO()->getIp(),
                    'created_at' => $incrementEventDTO->getBaseEventDTO()->getCreatedAt()
                ]
            ]
        ]);
    }
}
