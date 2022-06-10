<?php

declare(strict_types=1);

namespace Abrouter\Client\RemoteEntity\Repositories;

use Abrouter\Client\Builders\RequestBuilder;
use Abrouter\Client\Builders\UrlBuilder;
use Abrouter\Client\Config\Accessors\TokenConfigAccessor;
use Abrouter\Client\Http\RequestExecutor;
use Abrouter\Client\Transformers\ExperimentUsersRequestTransformer;

class ExperimentUserBranchesRepository
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

    public function getBranchesByUser(string $userSignature)
    {
        $request = $this->requestBuilder
            ->get()
            ->url($this->urlBuilder->listExperimentUsersUri($userSignature)->build())
            ->withHeaders([
                'Authorization' => $this->tokenConfigAccessor->getToken()
            ])
            ->build();

        $response = $this->requestExecutor->execute($request);

        return $this->experimentUsersRequestTransformer->transform($response);
    }
}
