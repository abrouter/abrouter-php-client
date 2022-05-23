<?php

declare(strict_types=1);

namespace Abrouter\Client\Contracts;

interface TaskManagerContract
{
    public function queue(TaskContract $task): void;
    public function work(int $iterationsLimit = 0): void;
}
