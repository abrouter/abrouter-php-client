<?php

declare(strict_types=1);

namespace Abrouter\Client;

use Abrouter\Client\Config\Accessors\ParallelRunConfigAccessor;
use Abrouter\Client\Contracts\TaskManagerContract;

class Worker
{
    private ParallelRunConfigAccessor $parallelRunConfigAccessor;

    public function __construct(ParallelRunConfigAccessor $parallelRunConfigAccessor)
    {
        $this->parallelRunConfigAccessor = $parallelRunConfigAccessor;
    }

    public function work(int $iterationsLimit = 0)
    {
        $this->parallelRunConfigAccessor->getTaskManager()->work($iterationsLimit);
    }
}
