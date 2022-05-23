<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Integration\ParallelRun;

use Abrouter\Client\Contracts\TaskContract;
use Abrouter\Client\Events\EventDispatcher;
use Abrouter\Client\Services\ExperimentsParallelRun\AddUserToBranchTask;
use Abrouter\Client\Services\TaskManager\TaskManager;
use Abrouter\Client\Tests\Integration\IntegrationTestCase;

class TaskManagerTest extends IntegrationTestCase
{
    public static bool $eventReceived = false;

    public static int $eventCountReceived = 0;
    public static string $experimentId = '';

    public function testReceiveSingleEvent()
    {
        $this->configureParallelRun();
        $this->clearRedis();

        $args = $this->createArgumentsFor(TaskManager::class);
        $args[1] = new class (...$this->createArgumentsFor(EventDispatcher::class)) extends EventDispatcher {
            public function dispatch(TaskContract $taskContract, bool $async = false): void
            {
                TaskManagerTest::$eventReceived = true;
            }
        };
        $taskManager = new TaskManager(...$args);
        $taskManager->queue(new AddUserToBranchTask(uniqid(), uniqid(), uniqid(), uniqid()));

        $taskManager->work(1);

        $this->assertTrue(self::$eventReceived);
    }

    public function testReceivingTenEvents()
    {
        $this->configureParallelRun();
        $this->clearRedis();

        foreach (range(1, 10) as $k) {
            $args = $this->createArgumentsFor(TaskManager::class);
            $args[1] = new class (...$this->createArgumentsFor(EventDispatcher::class)) extends EventDispatcher {
                public function dispatch(TaskContract $taskContract, $async = false): void
                {
                    if (!$taskContract instanceof AddUserToBranchTask) {
                        return ;
                    }

                    TaskManagerTest::$eventCountReceived++;
                    TaskManagerTest::$experimentId = $taskContract->getExperimentId();
                }
            };
            $taskManager = new TaskManager(...$args);
            $experimentId = uniqid();
            $taskManager->queue(new AddUserToBranchTask('alias', $experimentId, uniqid(), uniqid()));
            $taskManager->work(10);
            $this->assertEquals($experimentId, self::$experimentId);
            $this->assertTrue(self::$eventCountReceived === $k);
        }
    }
}
