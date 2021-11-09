<?php
declare(strict_types = 1);

namespace Abrouter\Client\JsonApiParser;

use Abrouter\Client\JsonApiParser\Entities\JsonApiEntity;
use Abrouter\Client\JsonApiParser\Entities\JsonApiEntityInterface;

class Parser
{
    public static function parse(array $data): JsonApiEntityInterface
    {
        return new JsonApiEntity(
            $data['attributes'],
            $data['relationships'],
            $data['meta']
        );
    }
}
