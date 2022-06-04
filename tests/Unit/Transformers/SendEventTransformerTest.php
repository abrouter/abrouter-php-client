<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Transformers;

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
                ->make(sendEventRequestTransformer::class);
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
                            'event' => $eventDTO->getEvent(),
                            'tag' => $eventDTO->getTag(),
                            'referrer' => $eventDTO->getReferrer(),
                            'ip' => $eventDTO->getIp(),
                            'meta' => $eventDTO->getMeta(),
                            'created_at' => $eventDTO->getCreatedAt()
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
