<?php

use Abrouter\Client\Config\Config;
use Abrouter\Client\Config\ParallelRunConfig;
use Abrouter\Client\Config\RedisConfig;
use Abrouter\Client\Contracts\KvStorageContract;
use Abrouter\Client\Services\KvStorage\KvStorage;
use Abrouter\Client\Services\TaskManager\TaskManager;
use DI\ContainerBuilder;

require '/app/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();


$container->set(
    RedisConfig::class,
    new RedisConfig(
        $_SERVER['REDIS_HOST'] ?? 'redis',
        6379,
        '',
        '',
        ''
    )
);

$host = 'https://abrouter.com';
$token = uniqid();

$config = new Config(
    $token,
    $host,
);
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


/**
 * @var Config $containerConfig
 */
$containerConfig = $container->get(Config::class);


/**
 * @var TaskManager $taskManager
 */
$taskManager = $container->make(TaskManager::class);
$taskManager->work();
