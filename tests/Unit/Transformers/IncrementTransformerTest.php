<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Transformers;

use Abrouter\Client\DTO\BaseEventDTO;
use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Entities\SentEvent;
use Abrouter\Client\Tests\Unit\TestCase;
use Abrouter\Client\Transformers\SendEventRequestTransformer;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use AbRouter\Client\DTO\IncrementalEventDTO;

class IncrementTransformerTest extends TestCase
{
    /**
     * @var SendEventRequestTransformer $sendEventRequestTransformer
     */
    private SendEventRequestTransformer $sendEventRequestTransformer;

    public function setUp(): void
    {
        $this->sendEventRequestTransformer = $this->getContainer()
                ->make(SendEventRequestTransformer::class);
    }

    /**
     * @return void
     * @throws InvalidJsonApiResponseException
     */
    public function testTransform()
    {
        $date = (new \DateTime())->format('Y-m-d');
        $incrementalEventDTO = new IncrementalEventDTO(new BaseEventDTO(
            'temporary_user_12345',
            'user_12345',
            'new_event',
            'new_tag',
            'abrouter',
            [],
            '255.255.255.255',
            $date
        ));

        $increment = $this->sendEventRequestTransformer->transform(
            new Response(
                [
                    'data' => [
                        'id' => uniqid(),
                        'type' => 'events',
                        'attributes' => [
                            'user_id' => $incrementalEventDTO->getBaseEventDTO()->getUserId(),
                            'event' => $incrementalEventDTO->getBaseEventDTO()->getEvent(),
                            'tag' => $incrementalEventDTO->getBaseEventDTO()->getTag(),
                            'referrer' => $incrementalEventDTO->getBaseEventDTO()->getReferrer(),
                            'ip' => $incrementalEventDTO->getBaseEventDTO()->getIp(),
                            'meta' => $incrementalEventDTO->getBaseEventDTO()->getMeta(),
                            'created_at' => $incrementalEventDTO->getBaseEventDTO()->getCreatedAt()
                        ],
                    ]
                ]
            )
        );

        $this->assertInstanceOf(SentEvent::class, $increment);
        $this->assertEquals($increment->isSuccessful(), true);
    }

    /**
     * @return void
     * @throws InvalidJsonApiResponseException
     */
    public function testException()
    {
        $this->expectException(InvalidJsonApiResponseException::class);
        $this->sendEventRequestTransformer->transform(
            new Response(
                [
                    'data' => [],
                ]
            )
        );
    }
}
