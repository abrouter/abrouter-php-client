<?php

namespace Abrouter\Client\Tests\Unit\Managers;

use Abrouter\Client\Builders\Payload\EventSendPayloadBuilder;
use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Entities\Client\ResponseInterface;
use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\Entities\SentEvent;
use Abrouter\Client\Manager\StatisticsManager;
use Abrouter\Client\Services\Statistics\SendEventService;
use Abrouter\Client\Tests\Unit\TestCase;
use Abrouter\Client\Requests\SendEventRequest;
use Abrouter\Client\Transformers\SendEventRequestTransformer;
use Abrouter\Client\DTO\EventDTO;

class StatisticsManagerTest extends TestCase
{
    public static SentEvent $sentEvent;

    /**
     * @return void
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function testSendEvent()
    {
        $this->bindConfig();

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

        $args = $this->createArgumentsFor(SendEventService::class);
        $args[0] = $sendEventRequest;
        $sendEventService = new class (...$args) extends SendEventService {
            public function sendEvent(EventDTO $eventDTO): SentEvent
            {
                $result = parent::sendEvent($eventDTO);
                StatisticsManagerTest::$sentEvent = $result;
                return $result;
            }
        };

        $this->getContainer()->set(SendEventService::class, $sendEventService);
        $statisticsManager = $this->getContainer()->make(StatisticsManager::class);
        $statisticsManager->sendEvent($eventDTO);

        $this->assertTrue(self::$sentEvent->isSuccessful());
    }
}
