<?php

namespace Abrouter\Client\Tests\Unit\Managers;

use Abrouter\Client\Builders\Payload\IncrementPayloadBuilder;
use Abrouter\Client\Builders\Payload\SummarizePayloadBuilder;
use Abrouter\Client\DTO\BaseEventDTO;
use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Entities\Client\ResponseInterface;
use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\Exceptions\SendEventRequestException;
use Abrouter\Client\Manager\StatisticsManager;
use Abrouter\Client\Tests\Unit\TestCase;
use Abrouter\Client\Requests\SendEventRequest;
use Abrouter\Client\Transformers\IncrementRequestTransformer;
use Abrouter\Client\Transformers\SummarizeRequestTransformer;
use Abrouter\Client\DTO\IncrementEventDTO;
use Abrouter\Client\DTO\SummarizeEventDTO;
use DI\DependencyException;
use DI\NotFoundException;

class StatisticsManagerTest extends TestCase
{
    /**
     * @return void
     * @throws InvalidJsonApiResponseException
     * @throws SendEventRequestException
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function testIncrementEvent()
    {
        $date = (new \DateTime())->format('Y-m-d');
        $incrementEventDTO = new IncrementEventDTO(new BaseEventDTO(
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
        $sendEventRequest = new class () extends SendEventRequest
        {
            public function __construct()
            {
            }

            /**
             * @param JsonPayload $jsonPayload
             * @return ResponseInterface
             */
            public function sendEvent(JsonPayload $jsonPayload): ResponseInterface
            {
                $date = (new \DateTime())->format('Y-m-d');
                return new Response(
                    [
                        'data' => [
                            'id' => uniqid(),
                            'type' => 'events',
                            'attributes' => [
                                'user_id' => 'user_12345',
                                'event' => 'new_event',
                                'value' => '',
                                'tag' => 'new_tag',
                                'referrer' => 'abrouter',
                                'ip' => '255.255.255.255',
                                'meta' => [],
                                'created_at' => $date
                            ],
                        ]
                    ]
                );
            }
        };

        $statisticsManager = new StatisticsManager(
            $sendEventRequest,
            $this->getContainer()->make(IncrementPayloadBuilder::class),
            $this->getContainer()->make(SummarizePayloadBuilder::class),
            $this->getContainer()->make(IncrementRequestTransformer::class),
            $this->getContainer()->make(SummarizeRequestTransformer::class)
        );

        $incrementEntity = $statisticsManager->increment($incrementEventDTO);

        $this->assertEquals($incrementEntity->isSuccessful(), true);
    }

    /**
     * @throws SendEventRequestException
     * @throws DependencyException
     * @throws NotFoundException
     * @throws InvalidJsonApiResponseException
     */
    public function testSummarizeEvent()
    {
        $date = (new \DateTime())->format('Y-m-d');
        $summarizeEventDTO = new SummarizeEventDTO('100',new BaseEventDTO(
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
        $sendEventRequest = new class () extends SendEventRequest
        {
            public function __construct()
            {
            }

            /**
             * @param JsonPayload $jsonPayload
             * @return ResponseInterface
             */
            public function sendEvent(JsonPayload $jsonPayload): ResponseInterface
            {
                $date = (new \DateTime())->format('Y-m-d');
                return new Response(
                    [
                        'data' => [
                            'id' => uniqid(),
                            'type' => 'events',
                            'attributes' => [
                                'user_id' => 'user_12345',
                                'event' => 'new_event',
                                'value' => '100',
                                'tag' => 'new_tag',
                                'referrer' => 'abrouter',
                                'ip' => '255.255.255.255',
                                'meta' => [],
                                'created_at' => $date
                            ],
                        ]
                    ]
                );
            }
        };

        $statisticsManager = new StatisticsManager(
            $sendEventRequest,
            $this->getContainer()->make(IncrementPayloadBuilder::class),
            $this->getContainer()->make(SummarizePayloadBuilder::class),
            $this->getContainer()->make(IncrementRequestTransformer::class),
            $this->getContainer()->make(SummarizeRequestTransformer::class)
        );

        $sendEventEntity = $statisticsManager->summarize($summarizeEventDTO);

        $this->assertEquals($sendEventEntity->isSuccessful(), true);
    }
}
