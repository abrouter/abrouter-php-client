<?php

declare(strict_types=1);

namespace Abrouter\Client\Contracts;

interface TasksCollectionContract
{
    public function __construct(TaskContract ...$tasks);

    /**
     * @return TaskContract[]
     */
    public function getAll(): array;
}
