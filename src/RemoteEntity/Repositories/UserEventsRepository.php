<?php

declare(strict_types=1);

namespace Abrouter\Client\RemoteEntity\Repositories;

use Abrouter\Client\Builders\RequestBuilder;
use Abrouter\Client\Builders\UrlBuilder;
use Abrouter\Client\Config\Accessors\TokenConfigAccessor;
use Abrouter\Client\Http\RequestExecutor;
use Abrouter\Client\RemoteEntity\Collections\StatisticEventsCollection;
use Abrouter\Client\Transformers\ExperimentUsersRequestTransformer;
use Abrouter\Client\Transformers\UserEventsRequestTransformer;

/**
 * Todo continue working on it
 */
class UserEventsRepository
{
    /**
     * @var UrlBuilder $urlBuilder
     */
    private UrlBuilder $urlBuilder;

    /**
     * @var RequestBuilder
     */
    private RequestBuilder $requestBuilder;


    /**
     * @var TokenConfigAccessor
     */
    private TokenConfigAccessor $tokenConfigAccessor;

    /**
     * @var RequestExecutor
     */
    private RequestExecutor $requestExecutor;

    private UserEventsRequestTransformer $userEventsRequestTransformer;

    public function __construct(
        UrlBuilder $urlBuilder,
        RequestBuilder $requestBuilder,
        TokenConfigAccessor $tokenConfigAccessor,
        RequestExecutor $requestExecutor,
        UserEventsRequestTransformer $userEventsRequestTransformer
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->requestBuilder = $requestBuilder;
        $this->tokenConfigAccessor = $tokenConfigAccessor;
        $this->requestExecutor = $requestExecutor;
        $this->userEventsRequestTransformer = $userEventsRequestTransformer;
    }

    public function getUserEvents(string $userId): StatisticEventsCollection
    {
        $request = $this->requestBuilder
            ->get()
            ->url($this->urlBuilder->listUserEvents($userId)->build())
            ->withHeaders([
                'Authorization' => $this->tokenConfigAccessor->getToken()
            ])
            ->build();

        $response = $this->requestExecutor->execute($request);

        return $this->userEventsRequestTransformer->transform($response);
    }
}
