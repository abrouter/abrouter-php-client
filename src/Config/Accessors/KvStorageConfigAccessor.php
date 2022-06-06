<?php

declare(strict_types=1);

namespace Abrouter\Client\Config\Accessors;

use Abrouter\Client\Contracts\KvStorageContract;

class KvStorageConfigAccessor extends BaseAccessor
{
    public function getKvStorage(): ?KvStorageContract
    {
        return $this->getConfig()->getKvStorage();
    }

    public function hasKvStorage(): bool
    {
        return $this->getConfig()->getKvStorage() !== null;
    }
}
