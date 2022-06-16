<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Integration;

use Abrouter\Client\Client;
use Abrouter\Client\DTO\BaseEventDTO;
use Abrouter\Client\DTO\IncrementalEventDTO;
use Abrouter\Client\DTO\SummarizeEventDTO;
use Abrouter\Client\RemoteEntity\Repositories\UserEventsRepository;
use Abrouter\Client\Worker;

class StatSendSyncTest extends IntegrationTestCase
{
    public function testIncrementStatSend()
    {
        $this->bindConfig(
            'https://abrouter.com',
            'add73bda37106bbddf2e6b3f61c6ed197c2250e99df9474ad01b9afb2035af33cf66c292fdf6a6e8',
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
            'add73bda37106bbddf2e6b3f61c6ed197c2250e99df9474ad01b9afb2035af33cf66c292fdf6a6e8',
        );
        $this->clearRedis();

        $client = $this->getContainer()->make(Client::class);
        $userSignature = 'test-run-f:' . uniqid();
        $client->statistics()->sendEvent(new SummarizeEventDTO('10', new BaseEventDTO(
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
            $this->assertEquals($event->getValue(), '10');
        }
    }
}
