<?php

declare(strict_types=1);

namespace Abrouter\Client\RemoteEntity\Repositories;

use Abrouter\Client\Builders\RequestBuilder;
use Abrouter\Client\Builders\UrlBuilder;
use Abrouter\Client\Config\Accessors\TokenConfigAccessor;
use Abrouter\Client\Http\RequestExecutor;
use Abrouter\Client\Transformers\ExperimentUsersRequestTransformer;

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

    private ExperimentUsersRequestTransformer $experimentUsersRequestTransformer;

    public function __construct(
        UrlBuilder $urlBuilder,
        RequestBuilder $requestBuilder,
        TokenConfigAccessor $tokenConfigAccessor,
        RequestExecutor $requestExecutor,
        ExperimentUsersRequestTransformer $experimentUsersRequestTransformer
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->requestBuilder = $requestBuilder;
        $this->tokenConfigAccessor = $tokenConfigAccessor;
        $this->requestExecutor = $requestExecutor;
        $this->experimentUsersRequestTransformer = $experimentUsersRequestTransformer;
    }
}
