<?php

declare(strict_types=1);

namespace Abrouter\Client\Requests;

use Abrouter\Client\Builders\UrlBuilder;
use Abrouter\Client\Config\Accessors\TokenConfigAccessor;
use Abrouter\Client\Builders\RequestBuilder;
use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Entities\Client\ResponseInterface;
use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\Http\RequestExecutor;
use Abrouter\Client\Exceptions\RunFeatureFlagRequestException;

class RunFeatureFlagRequest
{
    /**
     * @var RequestBuilder
     */
    private RequestBuilder $requestBuilder;

    /**
     * @var TokenConfigAccessor
     */
    private TokenConfigAccessor $tokenConfigAccessor;

    /**
     * @var UrlBuilder
     */
    private UrlBuilder $urlBuilder;

    /**
     * @var RequestExecutor
     */
    private RequestExecutor $requestExecutor;

    public function __construct(
        TokenConfigAccessor $tokenConfigAccessor,
        RequestBuilder $requestBuilder,
        UrlBuilder $urlBuilder,
        RequestExecutor $requestExecutor
    ) {
        $this->tokenConfigAccessor = $tokenConfigAccessor;
        $this->requestBuilder = $requestBuilder;
        $this->urlBuilder = $urlBuilder;
        $this->requestExecutor = $requestExecutor;
    }

    /**
     * @param JsonPayload $jsonPayload
     *
     * @return Response
     * @throws RunFeatureFlagRequestException
     */
    public function runFeatureFlag(JsonPayload $jsonPayload): ResponseInterface
    {
        $url = $this->urlBuilder->runFeatureFlagUri()->build();
        $request = $this
            ->requestBuilder
            ->post()
            ->url($url)
            ->withHeaders([
                'Authorization' => $this->tokenConfigAccessor->getToken()
            ])
            ->withJsonPayload($jsonPayload->getPayload())
            ->build();

        try {
            return $this->requestExecutor->execute($request);
        } catch (\Throwable $exception) {
            throw new RunFeatureFlagRequestException($exception->getMessage());
        }
    }
}
