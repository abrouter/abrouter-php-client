<?php

declare(strict_types=1);

namespace Abrouter\Client\Transformers;

use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\RemoteEntity\Collections\StatisticEventsCollection;
use Abrouter\Client\RemoteEntity\Entities\StatisticEvent;

/**
 * Todo continue working on it
 */
class UserEventsRequestTransformer
{
    public function transform(Response $response): StatisticEventsCollection
    {
        $items = array_reduce($response->getResponseJson()['data'], function (array $acc, array $item) {
            $acc[] = new StatisticEvent(
                $item['attributes']['event'],
                $item['attributes']['user_id'],
                $item['attributes']['temporary_user_id'] ?? '',
                $item['attributes']['tag'] ?? '',
                $item['attributes']['referrer'] ?? '',
                $item['attributes']['ip'] ?? '',
                $item['attributes']['created_at'] ?? '',
            );
            return $acc;
        }, []);

        return new StatisticEventsCollection(...$items);
    }
}
