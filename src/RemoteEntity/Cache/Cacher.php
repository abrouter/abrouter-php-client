<?php

declare(strict_types=1);

namespace Abrouter\Client\RemoteEntity\Cache;

use Abrouter\Client\Contracts\KvStorageContract;
use Abrouter\Client\Config\Accessors\KvStorageConfigAccessor;

class Cacher
{
    /**
     * @var KvStorageContract|null
     */
    private ?KvStorageContract $kvStorageContract;

    private bool $isEnabled;

    public function __construct(KvStorageConfigAccessor $kvStorageConfigAccessor)
    {
        $this->kvStorageContract = $kvStorageConfigAccessor->getKvStorage();
        $this->isEnabled = $kvStorageConfigAccessor->hasKvStorage();
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function fetch(string $id, string $type, int $expireIn, callable $fetchFunction): ?object
    {
        $objectId = $this->getObjectId($id, $type);
        $object = $this->kvStorageContract->get($objectId);
        if ($object !== null) {
            return unserialize($object);
        }

        $object = $fetchFunction();
        $this->kvStorageContract->put($objectId, serialize($object), $expireIn);
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
