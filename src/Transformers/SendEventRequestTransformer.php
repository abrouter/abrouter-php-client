<?php
declare(strict_types = 1);

namespace Abrouter\Client\Transformers;

use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Entities\SendEvent;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Art4\JsonApiClient\Exception\Exception;
use Art4\JsonApiClient\Helper\Parser;
use Art4\JsonApiClient\V1\Attributes;

class SendEventRequestTransformer
{
    /**
     * @param Response $response
     *
     * @return SendEvent
     * @throws InvalidJsonApiResponseException
     */
    public function transform(Response $response): SendEvent
    {
        try {
            $jsonApi = Parser::parseResponseString(json_encode($response->getResponseJson()));
            /**
             * @var Attributes $attributes
             */
            $attributes = $jsonApi->get('data.attributes');
            $userId = $attributes->get('user_id');
            $event = $attributes->get('event');
            $tag = $attributes->get('tag');
            $referrer = $attributes->get('referrer');
            $meta = $attributes->get('meta');
            $ip = $attributes->get('ip');

            return new SendEvent(
                $userId, 
                $event,
                $tag,
                $referrer,
                $meta,
                $ip
            );
        } catch (Exception $e) {
            throw new InvalidJsonApiResponseException($e->getMessage());
        }
    }
}