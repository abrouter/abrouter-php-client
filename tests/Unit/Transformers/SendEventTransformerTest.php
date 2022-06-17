<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Transformers;

use Abrouter\Client\DTO\BaseEventDTO;
use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Entities\SentEvent;
use Abrouter\Client\Tests\Unit\TestCase;
use Abrouter\Client\Transformers\SendEventRequestTransformer;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use AbRouter\Client\DTO\EventDTO;

class SendEventTransformerTest extends TestCase
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
        $eventDTO = new EventDTO(
            'temporary_user_12345',
            'user_12345',
            'new_event',
            'new_tag',
            'abrouter',
            [],
            '255.255.255.255',
            $date
        );

        $sentEvent = $this->sendEventRequestTransformer->transform(
            new Response(
                [
                    'data' => [
                        'id' => uniqid(),
                        'type' => 'events',
                        'attributes' => [
                            'user_id' => $eventDTO->getBaseEventDTO()->getUserId(),
                            'event' => $eventDTO->getBaseEventDTO()->getEvent(),
                            'tag' => $eventDTO->getBaseEventDTO()->getTag(),
                            'referrer' => $eventDTO->getBaseEventDTO()->getReferrer(),
                            'ip' => $eventDTO->getBaseEventDTO()->getIp(),
                            'meta' => $eventDTO->getBaseEventDTO()->getMeta(),
                            'created_at' => $eventDTO->getBaseEventDTO()->getCreatedAt()
                        ],
                    ]
                ]
            )
        );

        $this->assertInstanceOf(SentEvent::class, $sentEvent);
        $this->assertEquals($sentEvent->isSuccessful(), true);
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
