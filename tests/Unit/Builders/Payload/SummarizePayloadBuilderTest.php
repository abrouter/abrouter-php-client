<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Builders\Payload;

use Abrouter\Client\Builders\Payload\SummarizePayloadBuilder;
use Abrouter\Client\DTO\BaseEventDTO;
use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\DTO\SummarizeEventDTO;
use Abrouter\Client\Tests\Unit\TestCase;

class SummarizePayloadBuilderTest extends TestCase
{
    /** @var SummarizePayloadBuilder $summarizePayloadBuilder */
    private SummarizePayloadBuilder $summarizePayloadBuilder;

    /** @return void */
    public function setUp(): void
    {
        $this->summarizePayloadBuilder = $this->getContainer()
                ->make(SummarizePayloadBuilder::class);
    }

    /**
     * @return void
     */
    public function testPayloadIsCorrect()
    {
        $date = (new \DateTime())->format('Y-m-d');
        $summarizeEventDTO = new SummarizeEventDTO((string)mt_rand(1, 100),new BaseEventDTO(
            'owner_' . uniqid(),
            'temporary_user_' . uniqid(),
            'user_' . uniqid(),
            'new_event',
            'new_tag',
            'abrouter',
            [],
            '255.255.255.255',
            $date
            )
        );
        $payload = $this->summarizePayloadBuilder->build($summarizeEventDTO);
        $this->assertInstanceOf(JsonPayload::class, $payload);
        $this->assertEquals($payload->getPayload(),
            [
                'data' => [
                    'type' => 'events',
                    'attributes' => [
                        'event' => $summarizeEventDTO->getBaseEventDTO()->getEvent(),
                        'value' => $summarizeEventDTO->getValue(),
                        'user_id' => $summarizeEventDTO->getBaseEventDTO()->getUserId(),
                        'temporary_user_id' => $summarizeEventDTO->getBaseEventDTO()->getTemporaryUserId(),
                        'tag' => $summarizeEventDTO->getBaseEventDTO()->getTag(),
                        'referrer' => $summarizeEventDTO->getBaseEventDTO()->getReferrer(),
                        'meta' => $summarizeEventDTO->getBaseEventDTO()->getMeta(),
                        'ip' => $summarizeEventDTO->getBaseEventDTO()->getIp(),
                        'created_at' => $summarizeEventDTO->getBaseEventDTO()->getCreatedAt()
                    ],
                    'relationships' => [
                        'owner' => [
                            'data' => [
                                'id'   => $summarizeEventDTO->getBaseEventDTO()->getOwnerId(),
                                'type' => 'users',
                            ],
                        ],
                    ]
                ]
            ]
        );
    }
}
