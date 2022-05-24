<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Builders\Payload;

use Abrouter\Client\Builders\Payload\IncrementPayloadBuilder;
use Abrouter\Client\DTO\BaseEventDTO;
use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\DTO\IncrementEventDTO;
use Abrouter\Client\Tests\Unit\TestCase;

class IncrementPayloadBuilderTest extends TestCase
{
    /** @var IncrementPayloadBuilder $incrementPayloadBuilder */
    private IncrementPayloadBuilder $incrementPayloadBuilder;

    /** @return void */
    public function setUp(): void
    {
        $this->incrementPayloadBuilder = $this->getContainer()
                ->make(IncrementPayloadBuilder::class);
    }

    /**
     * @return void
     */
    public function testPayloadIsCorrect()
    {
        $date = (new \DateTime())->format('Y-m-d');
        $incrementEventDTO = new IncrementEventDTO(new BaseEventDTO(
            'owner_' . uniqid(),
            'temporary_user_' . uniqid(),
            'user_' . uniqid(),
            'new_event',
            'new_tag',
            'abrouter',
            [],
            '255.255.255.255',
            $date
        ));
        $payload = $this->incrementPayloadBuilder->build($incrementEventDTO);
        $this->assertInstanceOf(JsonPayload::class, $payload);
        $this->assertEquals($payload->getPayload(), [
            'data' => [
                'type' => 'events',
                'attributes' => [
                    'event' => $incrementEventDTO->getBaseEventDTO()->getEvent(),
                    'value' => '',
                    'user_id' => $incrementEventDTO->getBaseEventDTO()->getUserId(),
                    'temporary_user_id' => $incrementEventDTO->getBaseEventDTO()->getTemporaryUserId(),
                    'tag' => $incrementEventDTO->getBaseEventDTO()->getTag(),
                    'referrer' => $incrementEventDTO->getBaseEventDTO()->getReferrer(),
                    'meta' => $incrementEventDTO->getBaseEventDTO()->getMeta(),
                    'ip' => $incrementEventDTO->getBaseEventDTO()->getIp(),
                    'created_at' => $incrementEventDTO->getBaseEventDTO()->getCreatedAt()
                ],
                'relationships' => [
                    'owner' => [
                        'data' => [
                            'id'   => $incrementEventDTO->getBaseEventDTO()->getOwnerId(),
                            'type' => 'users',
                        ],
                    ],
                ]
            ]
        ]);
    }
}
