<?php
declare(strict_types = 1);

namespace Abrouter\Client\Transformers;

use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Entities\Statistics;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Art4\JsonApiClient\Exception\Exception;
use Art4\JsonApiClient\Helper\Parser;
use Art4\JsonApiClient\V1\Attributes;

class StatisticsRequestTransformer
{
    /**
     * @param Response $response
     *
     * @return RunExperiment
     * @throws InvalidJsonApiResponseException
     */
    public function transform(Response $response): RunExperiment
    {
        try {
            $jsonApi = Parser::parseResponseString(json_encode($response->getResponseJson()));
            /**
             * @var Attributes $attributes
             */
            $attributes = $jsonApi->get('data.attributes');
            $event = $attributes->get('event');
            
            return new Statistics($event);
        } catch (Exception $e) {
            throw new InvalidJsonApiResponseException($e->getMessage());
        }
    }
}