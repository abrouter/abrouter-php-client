<?php

declare(strict_types=1);

namespace Abrouter\Client\RemoteEntity\Cache;

use Abrouter\Client\Contracts\KvStorageContract;
use Abrouter\Client\Config\Accessors\KvStorageConfigAccessor;

class Cacher
{
    private KvStorageConfigAccessor $kvStorageConfigAccessor;

    public function __construct(KvStorageConfigAccessor $kvStorageConfigAccessor)
    {
        $this->kvStorageConfigAccessor = $kvStorageConfigAccessor;
    }

    public function isEnabled(): bool
    {
        return $this->kvStorageConfigAccessor->hasKvStorage();
    }

    public function fetch(string $id, string $type, int $expireIn, callable $fetchFunction): ?object
    {
        $objectId = $this->getObjectId($id, $type);
        $object = $this->kvStorageConfigAccessor->getKvStorage()->get($objectId);
        if ($object !== null) {
            return unserialize($object);
        }

        $object = $fetchFunction();
        $this->kvStorageConfigAccessor->getKvStorage()->put($objectId, serialize($object), $expireIn);
        return $object;
    }

    private function getObjectId(string $id, string $type): string
    {
        return join('', [
           $type,
           '-',
           $id
        ]);
    }
}
