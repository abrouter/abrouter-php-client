<?php

declare(strict_types=1);

namespace Abrouter\Client\Entities\Client;

interface ResponseInterface
{
    public function getResponseJson(): array;
}
