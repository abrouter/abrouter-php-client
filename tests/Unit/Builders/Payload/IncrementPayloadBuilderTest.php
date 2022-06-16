<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Builders\Payload;

use Abrouter\Client\Builders\Payload\SendEventPayloadBuilder;
use Abrouter\Client\DTO\BaseEventDTO;
use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\DTO\IncrementalEventDTO;
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
        $incrementalEventDTO = new IncrementalEventDTO(new BaseEventDTO(
            'temporary_user_' . uniqid(),
            'user_' . uniqid(),
            'new_event',
            'new_tag',
            'abrouter',
            [],
            '255.255.255.255',
            $date
        ));
        $payload = $this->sendEventPayloadBuilder->build($incrementalEventDTO);
        $this->assertInstanceOf(JsonPayload::class, $payload);
        $this->assertEquals($payload->getPayload(), [
            'data' => [
                'type' => 'events',
                'attributes' => [
                    'event' => $incrementalEventDTO->getBaseEventDTO()->getEvent(),
                    'user_id' => $incrementalEventDTO->getBaseEventDTO()->getUserId(),
                    'temporary_user_id' => $incrementalEventDTO->getBaseEventDTO()->getTemporaryUserId(),
                    'value' => null,
                    'tag' => $incrementalEventDTO->getBaseEventDTO()->getTag(),
                    'referrer' => $incrementalEventDTO->getBaseEventDTO()->getReferrer(),
                    'meta' => $incrementalEventDTO->getBaseEventDTO()->getMeta(),
                    'ip' => $incrementalEventDTO->getBaseEventDTO()->getIp(),
                    'created_at' => $incrementalEventDTO->getBaseEventDTO()->getCreatedAt()
                ]
            ]
        ]);
    }
}
