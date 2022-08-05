<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Integration\DB\Repositories;

use Abrouter\Client\DB\Managers\ParallelRunningStateManager;
use Abrouter\Client\DB\Repositories\ParallelRunningStateRepository;
use Abrouter\Client\Tests\Integration\IntegrationTestCase;

class ParallelRunningStateRepositoryTest extends IntegrationTestCase
{
    public function testReadyToServe()
    {
        $this->configureParallelRun('default');
        $this->clearRedis();

        /**
         * @var ParallelRunningStateManager $manager
         */
        $manager = $this->getContainer()->make(ParallelRunningStateManager::class);
        $manager->setReadyToServe();

        /**
         * @var ParallelRunningStateRepository $repository
         */
        $repository = $this->getContainer()->make(ParallelRunningStateRepository::class);

        $this->assertTrue($repository->isReady());
    }

    public function testInitialized()
    {
        $this->configureParallelRun('default');
        $this->clearRedis();

        /**
         * @var ParallelRunningStateManager $manager
         */
        $manager = $this->getContainer()->make(ParallelRunningStateManager::class);
        $manager->setInitialized();

        /**
         * @var ParallelRunningStateRepository $repository
         */
        $repository = $this->getContainer()->make(ParallelRunningStateRepository::class);

        $this->assertTrue($repository->isInitialized());
    }

    public function testNotInitialized()
    {
        $this->configureParallelRun('default');
        $this->clearRedis();

        /**
         * @var ParallelRunningStateRepository $repository
         */
        $repository = $this->getContainer()->make(ParallelRunningStateRepository::class);

        $this->assertFalse($repository->isInitialized());
    }

    public function testNotReady()
    {
        $this->configureParallelRun('default');
        $this->clearRedis();

        /**
         * @var ParallelRunningStateRepository $repository
         */
        $repository = $this->getContainer()->make(ParallelRunningStateRepository::class);

        $this->assertFalse($repository->isReady());
    }
}
