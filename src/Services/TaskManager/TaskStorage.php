<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\TaskManager;

use Abrouter\Client\Contracts\TaskContract;
use Abrouter\Client\DB\RedisConnection;

class TaskStorage
{
    private const HSET_KEY = 'tasks';
    private const TASK_INCREMENT = 'task-increment';
    private const TASK_OFFSET = 'task-offset';

    private RedisConnection $redisConnection;

    public function __construct(RedisConnection $redisConnection)
    {
        $this->redisConnection = $redisConnection;
    }

    public function publish(TaskContract $taskContract)
    {
        $connection = $this->redisConnection->getConnection();
        $taskId = $connection->get(self::TASK_INCREMENT);
        if ($taskId === null) {
            $taskId = 1;
            $connection->set(self::TASK_INCREMENT, $taskId);
        }
        $connection->set(self::TASK_INCREMENT, $taskId + 1);

        $connection->hset(self::HSET_KEY, $taskId, serialize($taskContract));
    }

    public function subscribe(callable $f, int $iterationsLimit = 0)
    {
        $counter = 0;
        while (true) {
            $counter++;
            $connection = $this->redisConnection->getConnection();
            $keys = $connection->hkeys(self::HSET_KEY);
            $offset = $connection->get(self::TASK_OFFSET) ?? 0;
            $actualKeys = array_reduce($keys, function (array $acc, string $key) use ($offset) {
                if ($key > $offset) {
                    $acc[] = $key;
                }

                return $acc;
            }, []);
            sort($actualKeys);

            array_reduce($actualKeys, function (array $acc, $key) use ($f) {
                try {
                    $payload = $this->redisConnection->getConnection()->hget(self::HSET_KEY, $key);
                    $event = unserialize($payload);
                    $f($event);
                } catch (\Throwable $e) {
                    echo $e->getMessage();
                }

                $this->redisConnection->getConnection()->set(self::TASK_OFFSET, $key);
                return $acc;
            }, []);

            if ($iterationsLimit > 0 && $counter === $iterationsLimit) {
                break;
            }
        }
    }
}
