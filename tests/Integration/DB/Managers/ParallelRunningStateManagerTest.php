<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Integration\DB\Managers;

use Abrouter\Client\DB\Dictionary\ParallelRunningDictionary;
use Abrouter\Client\DB\Managers\ParallelRunningStateManager;
use Abrouter\Client\DB\RedisConnection;
use Abrouter\Client\Tests\Integration\IntegrationTestCase;

class ParallelRunningStateManagerTest extends IntegrationTestCase
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

        $redis = $this->getContainer()->make(RedisConnection::class);

        $value = $redis->getConnection()->get(ParallelRunningDictionary::IS_RUNNING_KEY);
        $this->assertEquals(ParallelRunningDictionary::IS_RUNNING_VALUE_TRUE, $value);
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

        $redis = $this->getContainer()->make(RedisConnection::class);

        $value = $redis->getConnection()->get(ParallelRunningDictionary::IS_INITIAZLIED_KEY);
        $this->assertEquals(ParallelRunningDictionary::IS_INITIAZLIED_TRUE_VALUE, $value);
    }

    public function testStopServing()
    {
        $this->configureParallelRun('default');
        $this->clearRedis();

        /**
         * @var ParallelRunningStateManager $manager
         */
        $manager = $this->getContainer()->make(ParallelRunningStateManager::class);
        $manager->setStopServing();

        $redis = $this->getContainer()->make(RedisConnection::class);

        $value = $redis->getConnection()->get(ParallelRunningDictionary::IS_RUNNING_KEY);
        $this->assertEquals(ParallelRunningDictionary::IS_RUNNING_VALUE_STOPPED, $value);
    }
}
