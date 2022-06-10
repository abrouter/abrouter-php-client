<?php

declare(strict_types=1);

namespace Abrouter\Client\Config\Accessors;

class HostConfigAccessor extends BaseAccessor
{
    public function getHost(): string
    {
        return $this->getConfig()->getHost();
    }
}
