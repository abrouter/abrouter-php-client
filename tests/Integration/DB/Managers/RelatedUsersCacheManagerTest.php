<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Integration\DB\Managers;

use Abrouter\Client\DB\Dictionary\ParallelRunningDictionary;
use Abrouter\Client\DB\RedisConnection;
use Abrouter\Client\DB\Repositories\RelatedUsersCacheRepository;
use Abrouter\Client\Tests\Integration\IntegrationTestCase;

class RelatedUsersCacheManagerTest extends IntegrationTestCase
{
    public function testSavingSomeUsers()
    {
        $this->configureParallelRun('default');
        $this->clearRedis();

        $relatedUsersList = ['test' => ['test2']];
        $relatedUsersCacheRepository = $this->getContainer()->make(RelatedUsersCacheRepository::class);
        $redis = $this->getContainer()->make(RedisConnection::class);
        $redis->getConnection()->set(
            ParallelRunningDictionary::RELATED_USERS_KEY,
            json_encode($relatedUsersList)
        );

        $this->assertEquals($relatedUsersCacheRepository->getAll(), $relatedUsersList);
    }
}
