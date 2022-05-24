<?php
declare(strict_types=1);

namespace Abrouter\Client\Transformers;

use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Entities\Summarize;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Art4\JsonApiClient\Exception\Exception;
use Art4\JsonApiClient\Helper\Parser;
use Art4\JsonApiClient\V1\Attributes;

class SummarizeRequestTransformer
{
    /**
     * @param Response $response
     *
     * @return Summarize
     * @throws InvalidJsonApiResponseException
     */
    public function transform(Response $response): Summarize
    {
        try {
            $jsonApi = Parser::parseResponseString(json_encode($response->getResponseJson()));
            /**
             * @var Attributes $attributes
             */
            $attributes = $jsonApi->get('data.attributes');
            $event = $attributes->get('event');
            $value = $attributes->get('value');

            return new Summarize(
                $event,
                $value
            );
        } catch (Exception $e) {
            throw new InvalidJsonApiResponseException($e->getMessage());
        }
    }
}
