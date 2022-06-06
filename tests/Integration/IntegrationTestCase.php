<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Integration;

use Abrouter\Client\Client;
use Abrouter\Client\Config\Config;
use Abrouter\Client\Config\ParallelRunConfig;
use Abrouter\Client\Config\RedisConfig;
use Abrouter\Client\Contracts\KvStorageContract;
use Abrouter\Client\DB\RedisConnection;
use Abrouter\Client\Services\KvStorage\KvStorage;
use Abrouter\Client\Services\TaskManager\TaskManager;
use DI\Container;
use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase as BaseTestCase;

class IntegrationTestCase extends BaseTestCase
{
    private const TEST_HOST = 'https://127.0.0.1';

    /**
     * @var Container $container
     */
    private Container $container;

    /**
     * @var string $token
     */
    private string $token;

    /**
     * @var string $host
     */
    private string $host;

    public function getContainer()
    {
        if (isset($this->container)) {
            return $this->container;
        }

        $containerBuilder = new ContainerBuilder();
        $container = $containerBuilder->build();
        $this->container = $container;
        return $container;
    }

    protected function bindConfig(string $host = self::TEST_HOST, string $token = null): void
    {
        $this->host = $host;
        $this->token = $token ?? uniqid();

        $config = new Config($this->token, $this->host);
        $this->getContainer()->set(Config::class, $config);
    }

    public function getConfig(): Config
    {
        return $this->getContainer()->get(Config::class);
    }

    protected function configureParallelRun(string $token = null): void
    {
        $container = $this->getContainer();

        $redisConfig = new RedisConfig(
            $_SERVER['REDIS_HOST'] ?? 'redis',
            6379,
            '',
            '',
            ''
        );

        $host = 'https://abrouter.com';
        $token = $token ?? uniqid();

        $config = new Config(
            $token,
            $host,
        );
        $config->setRedisConfig($redisConfig);
        $container->set(Config::class, $config);

        $kvStorage = $container->make(KvStorage::class);
        $container->make(KvStorage::class);
        $container->set(
            KvStorageContract::class,
            $kvStorage
        );

        $config->setKvStorageConfig($kvStorage);
        $container->set(Config::class, $config);
        $taskManager = $container->make(TaskManager::class);

        $config->setParallelRunConfig(new ParallelRunConfig(true, $taskManager));
    }

    protected function getClient(): Client
    {
        return $this->container->make(Client::class);
    }

    /**
     * @throws \ReflectionException
     */
    protected function createArgumentsFor(string $class)
    {
        $reflection = new \ReflectionClass($class);

        if ($reflection->getConstructor() === null) {
            return new $class();
        }

        $argumentsNeeded = $reflection->getConstructor()->getParameters();
        $arguments = array_reduce($argumentsNeeded, function (array $acc, \ReflectionParameter $reflectionParameter) {
            try {
                $acc[] = $this->getContainer()->make($reflectionParameter->getType()->getName());
            } catch (\Throwable $e) {
                $acc[] = null;
            }

            return $acc;
        }, []);

        return $arguments;
    }

    protected function clearRedis(): void
    {
        $this->getContainer()->make(RedisConnection::class)->getConnection()->flushall();
    }
}
