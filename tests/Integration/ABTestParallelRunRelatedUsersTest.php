<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Integration;

use Abrouter\Client\Builders\StatEventBuilder;
use Abrouter\Client\Client;
use Abrouter\Client\Services\ExperimentsParallelRun\ParallelRunSwitch;
use Abrouter\Client\Worker;

class ABTestParallelRunRelatedUsersTest extends IntegrationTestCase
{
    public function testABTestRunRelatedUsers()
    {
        $this->configureParallelRun('default');
        $this->clearRedis();

        $client = $this->getContainer()->make(Client::class);
        $temporaryUserSignature = 'test-run-f:' . uniqid();
        $userSignature = 'test-run-f-2:' . uniqid();
        $userSignature2 = 'test-run-f-3:' . uniqid();
        $userSignature3 = 'test-run-f-4:' . uniqid();

        $run = $client->experiments()->run($temporaryUserSignature, 'example_experiment');

        $switch = $this->getContainer()->make(ParallelRunSwitch::class);
        $this->assertTrue($switch->isEnabled());

        $this->assertTrue(in_array($run->getBranchId(), ['first_branch', 'second_branch']));

        $this->assertTrue($run->getExperimentId() === 'example_experiment');

        //add related users

        $eventBuilder = $this->getContainer()->make(StatEventBuilder::class);
        $client->statistics()->sendEvent(
            $eventBuilder
                ->incremental()
                ->event('sign_up')
                ->setTemporaryUserId($temporaryUserSignature)
                ->setUserId($userSignature)
                ->build()
        );

        $client->statistics()->sendEvent(
            $eventBuilder
                ->incremental()
                ->event('sign_up')
                ->setTemporaryUserId($temporaryUserSignature)
                ->setUserId($userSignature2)
                ->build()
        );

        $client->statistics()->sendEvent(
            $eventBuilder
                ->incremental()
                ->event('sign_up')
                ->setTemporaryUserId($temporaryUserSignature)
                ->setUserId($userSignature3)
                ->build()
        );

        $worker = $this->getContainer()->make(Worker::class);
        $worker->work(10);

        //then, we expect events should be catched by related users interceptor

        $runResult2 = $client->experiments()->run($userSignature, 'example_experiment');
        $runResult3 = $client->experiments()->run($userSignature2, 'example_experiment');
        $runResult4 = $client->experiments()->run($userSignature3, 'example_experiment');

        $this->assertEquals(
            $runResult2->getBranchId(),
            $run->getBranchId()
        );

        $this->assertEquals(
            $runResult3->getBranchId(),
            $run->getBranchId()
        );

        $this->assertEquals(
            $runResult4->getBranchId(),
            $run->getBranchId()
        );

        $this->assertEquals(
            $runResult2->getBranchId(),
            $runResult3->getBranchId()
        );

        $this->assertEquals(
            $runResult3->getBranchId(),
            $runResult4->getBranchId()
        );
    }
}
