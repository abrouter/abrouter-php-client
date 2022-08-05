<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Integration\DB\Repositories;

use Abrouter\Client\DB\Managers\ParallelRunningStateManager;
use Abrouter\Client\DB\Repositories\ParallelRunningStateCachedRepository;
use Abrouter\Client\Tests\Integration\IntegrationTestCase;

class ParallelRunningStateCachedRepositoryTest extends IntegrationTestCase
{
    public function testReadyToServe()
    {
        $this->configureParallelRun('default');
        $this->clearRedis();
        $this->clearRunTimeCache();

        /**
         * @var ParallelRunningStateManager $manager
         */
        $manager = $this->getContainer()->make(ParallelRunningStateManager::class);
        $manager->setReadyToServe();

        /**
         * @var ParallelRunningStateCachedRepository $repository
         */
        $repository = $this->getContainer()->make(ParallelRunningStateCachedRepository::class);

        $this->assertTrue($repository->isReady());
    }

    public function testNotInitialized()
    {
        $this->configureParallelRun('default');
        $this->clearRedis();
        $this->clearRunTimeCache();

        /**
         * @var ParallelRunningStateCachedRepository $repository
         */
        $repository = $this->getContainer()->make(ParallelRunningStateCachedRepository::class);

        $this->assertFalse($repository->isInitialized());
    }

    public function testNotReady()
    {
        $this->configureParallelRun('default');
        $this->clearRedis();
        $this->clearRunTimeCache();

        /**
         * @var ParallelRunningStateCachedRepository $repository
         */
        $repository = $this->getContainer()->make(ParallelRunningStateCachedRepository::class);

        $this->assertFalse($repository->isReady());
    }
}
