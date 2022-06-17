<?php

namespace Abrouter\Client\Tests\Unit\Managers;

use Abrouter\Client\DTO\BaseEventDTO;
use Abrouter\Client\DTO\EventDTO;
use Abrouter\Client\DTO\EventDTOInterface;
use Abrouter\Client\DTO\IncrementalEventDTO;
use Abrouter\Client\DTO\SummarizeEventDTO;
use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Entities\Client\ResponseInterface;
use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\Entities\SentEvent;
use Abrouter\Client\Manager\StatisticsManager;
use Abrouter\Client\Services\Statistics\SendEventService;
use Abrouter\Client\Tests\Unit\TestCase;
use Abrouter\Client\Requests\SendEventRequest;

class StatisticsManagerTest extends TestCase
{
    public static SentEvent $sentEvent;

    /**
     * @return void
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \ReflectionException
     */
    public function testSendIncrementEvent()
    {
        $this->bindConfig();

        $date = (new \DateTime())->format('Y-m-d');
        $eventDTO = new IncrementalEventDTO(new BaseEventDTO(
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
                                'temporary_user_id' => 'temporary_user_12345',
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
            public function sendEvent(EventDTOInterface $eventDTO): SentEvent
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

    /**
     * @return void
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \ReflectionException
     */
    public function testSendSummarizableEvent()
    {
        $this->bindConfig();

        $date = (new \DateTime())->format('Y-m-d');
        $eventDTO = new SummarizeEventDTO('100', new BaseEventDTO(
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
                                'temporary_user_id' => 'temporary_user_12345',
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
            public function sendEvent(EventDTOInterface $eventDTO): SentEvent
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

    /**
     * @return void
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \ReflectionException
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
                                'temporary_user_id' => 'temporary_user_12345',
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
            public function sendEvent(EventDTOInterface $eventDTO): SentEvent
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
