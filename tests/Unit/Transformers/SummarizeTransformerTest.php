<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Transformers;

use Abrouter\Client\DTO\BaseEventDTO;
use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Entities\SentEvent;
use Abrouter\Client\Tests\Unit\TestCase;
use Abrouter\Client\Transformers\SendEventRequestTransformer;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use AbRouter\Client\DTO\SummarizeEventDTO;

class SummarizeTransformerTest extends TestCase
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
        $summarizeEventDTO = new SummarizeEventDTO((string)mt_rand(1, 100), new BaseEventDTO(
            'owner_12345',
            'temporary_user_12345',
            'user_12345',
            'new_event',
            'new_tag',
            'abrouter',
            [],
            '255.255.255.255',
            $date
        ));

        $summarize = $this->sendEventRequestTransformer->transform(
            new Response(
                [
                    'data' => [
                        'id' => uniqid(),
                        'type' => 'events',
                        'attributes' => [
                            'user_id' => $summarizeEventDTO->getBaseEventDTO()->getUserId(),
                            'event' => $summarizeEventDTO->getBaseEventDTO()->getEvent(),
                            'value' => $summarizeEventDTO->getValue(),
                            'tag' => $summarizeEventDTO->getBaseEventDTO()->getTag(),
                            'referrer' => $summarizeEventDTO->getBaseEventDTO()->getReferrer(),
                            'ip' => $summarizeEventDTO->getBaseEventDTO()->getIp(),
                            'meta' => $summarizeEventDTO->getBaseEventDTO()->getMeta(),
                            'created_at' => $summarizeEventDTO->getBaseEventDTO()->getCreatedAt()
                        ],
                    ]
                ]
            )
        );

        $this->assertInstanceOf(SentEvent::class, $summarize);
        $this->assertEquals($summarize->isSuccessful(), true);
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
