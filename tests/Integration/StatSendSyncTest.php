<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Integration;

use Abrouter\Client\Builders\StatEventBuilder;
use Abrouter\Client\Client;
use Abrouter\Client\DTO\BaseEventDTO;
use Abrouter\Client\DTO\EventDTO;
use Abrouter\Client\DTO\IncrementalEventDTO;
use Abrouter\Client\DTO\SummarizeEventDTO;
use Abrouter\Client\RemoteEntity\Repositories\UserEventsRepository;
use Abrouter\Client\Worker;

class StatSendSyncTest extends IntegrationTestCase
{
    public function testStatSend()
    {
        $this->bindConfig(
            'https://abrouter.com',
            'default',
        );
        $this->clearRedis();

        $client = $this->getContainer()->make(Client::class);
        $userSignature = 'test-run-f:' . uniqid();
        $client->statistics()->sendEvent(new EventDTO(
            '',
            $userSignature,
            'event1',
            '',
            '',
            [],
            '',
        ));

        $userEventsRepository = $this->getContainer()->make(UserEventsRepository::class);
        $events = $userEventsRepository->getUserEvents($userSignature);

        $this->assertEquals(1, sizeof($events->getStatisticEvents()));
        foreach ($events->getStatisticEvents() as $event) {
            $this->assertEquals($event->getEvent(), 'event1');
        }
    }

    public function testIncrementStatSend()
    {
        $this->bindConfig(
            'https://abrouter.com',
            'default',
        );
        $this->clearRedis();

        $client = $this->getContainer()->make(Client::class);
        $userSignature = 'test-run-f:' . uniqid();
        $client->statistics()->sendEvent(new IncrementalEventDTO(new BaseEventDTO(
            '',
            $userSignature,
            'event1',
            '',
            '',
            [],
            '',
        )));

        $userEventsRepository = $this->getContainer()->make(UserEventsRepository::class);
        $events = $userEventsRepository->getUserEvents($userSignature);

        $this->assertEquals(1, sizeof($events->getStatisticEvents()));
        foreach ($events->getStatisticEvents() as $event) {
            $this->assertEquals($event->getEvent(), 'event1');
        }
    }

    public function testSummarizableStatSend()
    {
        $this->bindConfig(
            'https://abrouter.com',
            'default',
        );
        $this->clearRedis();

        $client = $this->getContainer()->make(Client::class);
        $userSignature = 'test-run-f:' . uniqid();
        $client->statistics()->sendEvent(new SummarizeEventDTO('10', new BaseEventDTO(
            '',
            $userSignature,
            'event1_sum',
            '',
            '',
            [],
            '',
        )));

        $userEventsRepository = $this->getContainer()->make(UserEventsRepository::class);
        $events = $userEventsRepository->getUserEvents($userSignature);

        $this->assertEquals(1, sizeof($events->getStatisticEvents()));
        foreach ($events->getStatisticEvents() as $event) {
            $this->assertEquals($event->getEvent(), 'event1_sum');
            $this->assertEquals($event->getValue(), '10');
        }
    }

    public function testSummarizableStatSendWithBuilder()
    {
        $this->bindConfig(
            'https://abrouter.com',
            'default',
        );
        $this->clearRedis();

        $client = $this->getContainer()->make(Client::class);

        $eventBuilder = $this->getContainer()->make(StatEventBuilder::class);

        $userSignature = 'test-run-f:' . uniqid();
        $client->statistics()->sendEvent(
            $eventBuilder
                ->summarize()
                ->event('event1_sum')
                ->setUserId($userSignature)
                ->setValue('10')
                ->build()
        );

        $userEventsRepository = $this->getContainer()->make(UserEventsRepository::class);
        $events = $userEventsRepository->getUserEvents($userSignature);

        $this->assertEquals(1, sizeof($events->getStatisticEvents()));
        foreach ($events->getStatisticEvents() as $event) {
            $this->assertEquals($event->getEvent(), 'event1_sum');
            $this->assertEquals($event->getValue(), '10');
        }
    }

    public function testIncrementalStatSendWithBuilder()
    {
        $this->bindConfig(
            'https://abrouter.com',
            'default',
        );
        $this->clearRedis();

        $client = $this->getContainer()->make(Client::class);

        $eventBuilder = $this->getContainer()->make(StatEventBuilder::class);

        $userSignature = 'test-run-f:' . uniqid();
        $client->statistics()->sendEvent(
            $eventBuilder
                ->incremental()
                ->event('event1')
                ->setUserId($userSignature)
                ->build()
        );

        $userEventsRepository = $this->getContainer()->make(UserEventsRepository::class);
        $events = $userEventsRepository->getUserEvents($userSignature);

        $this->assertEquals(1, sizeof($events->getStatisticEvents()));
        foreach ($events->getStatisticEvents() as $event) {
            $this->assertEquals($event->getEvent(), 'event1');
        }
    }
}
