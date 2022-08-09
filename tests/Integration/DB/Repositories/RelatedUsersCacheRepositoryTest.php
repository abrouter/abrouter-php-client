<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Integration\DB\Repositories;

use Abrouter\Client\DB\Dictionary\ParallelRunningDictionary;
use Abrouter\Client\DB\Managers\RelatedUsersCacheManager;
use Abrouter\Client\DB\RedisConnection;
use Abrouter\Client\Tests\Integration\IntegrationTestCase;

class RelatedUsersCacheRepositoryTest extends IntegrationTestCase
{
    public function testGet()
    {
        $this->configureParallelRun('default');
        $this->clearRedis();

        $usersList = [
            'test' => ['test'],
        ];
        $relatedUsersCacheManager = $this->getContainer()->make(RelatedUsersCacheManager::class);
        $relatedUsersCacheManager->store($usersList);

        $redis = $this->getContainer()->make(RedisConnection::class);
        $this->assertEquals(
            $usersList,
            json_decode($redis->getConnection()->get(ParallelRunningDictionary::RELATED_USERS_KEY), true)
        );
    }
}
