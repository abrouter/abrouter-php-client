<?php
declare(strict_types = 1);

namespace Abrouter\Client\Transformers;

use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Art4\JsonApiClient\Exception\Exception;
use Art4\JsonApiClient\Helper\Parser;
use Art4\JsonApiClient\V1\Attributes;

class RunFeatureFlagRequestTransformer
{
    /**
     * @param Response $response
     *
     * @return bool
     * @throws InvalidJsonApiResponseException
     */
    public function transform(Response $response): bool
    {
        try {
            $jsonApi = Parser::parseResponseString(json_encode($response->getResponseJson()));
            /**
             * @var Attributes $attributes
             */
            $attributes = $jsonApi->get('data.attributes');
            $isEnabled = $attributes->get('is_enabled');

            return $isEnabled;
        } catch (Exception $e) {
            throw new InvalidJsonApiResponseException($e->getMessage());
        }
    }
}