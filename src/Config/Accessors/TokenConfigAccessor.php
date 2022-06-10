<?php

declare(strict_types=1);

namespace Abrouter\Client\Config\Accessors;

class TokenConfigAccessor extends BaseAccessor
{
    public function getToken(): string
    {
        return $this->getConfig()->getToken();
    }
}
