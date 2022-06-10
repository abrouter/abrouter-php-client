<?php

declare(strict_types=1);

namespace Abrouter\Client\Collections;

use Abrouter\Client\Contracts\TaskContract;
use Abrouter\Client\Contracts\TasksCollectionContract;

class TasksCollection implements TasksCollectionContract
{
    /**
     * @var TaskContract[]
     */
    private array $tasks;

    public function __construct(TaskContract ...$tasks)
    {
        $this->tasks = $tasks;
    }

    public function getAll(): array
    {
        return $this->tasks;
    }
}
