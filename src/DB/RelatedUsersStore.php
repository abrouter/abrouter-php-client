<?php

declare(strict_types=1);

namespace Abrouter\Client\DB;

use Abrouter\Client\Exceptions\RelatedUsersStoreLoadException;
use Abrouter\RelatedUsers\Collections\RelatedUsersCollection;

class RelatedUsersStore
{
    private static ?RelatedUsersCollection $store = null;

    /**
     * @throws RelatedUsersStoreLoadException
     */
    public function get(): RelatedUsersCollection
    {
        if (self::$store !== null) {
            return self::$store;
        }

        throw new RelatedUsersStoreLoadException('Related users store should be initialized');
    }

    public static function load(array $relatedUsersList): void
    {
        self::$store = new RelatedUsersCollection($relatedUsersList);
    }

    public static function isLoaded(): bool
    {
        return self::$store !== null;
    }
}
