<?php

declare(strict_types=1);

namespace Abrouter\Client\Events;

use Abrouter\Client\Contracts\TaskContract;

interface HandlerInterface
{
    public function handle(TaskContract $taskContract): bool;
}
