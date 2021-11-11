<?php
declare(strict_types = 1);

namespace Abrouter\Client\JsonApiParser;

use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\JsonApiParser\Entities\JsonApiEntity;
use Abrouter\Client\JsonApiParser\Entities\JsonApiEntityInterface;

class Parser
{
    /**
     * @param array $data
     *
     * @return JsonApiEntityInterface
     * @throws InvalidJsonApiResponseException
     */
    public static function parse(array $data): JsonApiEntityInterface
    {
        if (empty($data['data']['attributes'])) {
            throw new InvalidJsonApiResponseException('Invalid json');
        }
        
        return new JsonApiEntity(
            $data['data']['attributes'],
            !empty($data['data']['relationships']) ? $data['data']['relationships'] : [],
            !empty($data['data']['meta']) ? $data['data']['meta'] : [],
        );
    }
}
