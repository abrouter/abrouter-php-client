<?php

declare(strict_types=1);

namespace Abrouter\Client\RemoteEntity\Managers;

use Abrouter\Client\Builders\RequestBuilder;
use Abrouter\Client\Builders\UrlBuilder;
use Abrouter\Client\Config\Accessors\TokenConfigAccessor;
use Abrouter\Client\Http\RequestExecutor;
use Abrouter\Client\RemoteEntity\Repositories\Cached\ExperimentBranchesCacheRepository;

class UserBranchManager
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

    /**
     * @var ExperimentBranchesCacheRepository
     */
    private ExperimentBranchesCacheRepository $experimentBranchesCacheRepository;

    public function __construct(
        UrlBuilder $urlBuilder,
        RequestBuilder $requestBuilder,
        TokenConfigAccessor $tokenConfigAccessor,
        RequestExecutor $requestExecutor,
        ExperimentBranchesCacheRepository $experimentBranchesCacheRepository
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->requestBuilder = $requestBuilder;
        $this->tokenConfigAccessor = $tokenConfigAccessor;
        $this->requestExecutor = $requestExecutor;
        $this->experimentBranchesCacheRepository = $experimentBranchesCacheRepository;
    }

    public function addUserToBranch(
        string $experimentId,
        string $experimentAlias,
        string $branchUid,
        string $userSignature
    ): void {
        $branchId = $this->experimentBranchesCacheRepository->getBranchIdByUid($experimentAlias, $branchUid);

        $request = $this->requestBuilder
            ->post()
            ->url($this->urlBuilder->addUserToExp()->build())
            ->withHeaders([
                'Authorization' => $this->tokenConfigAccessor->getToken()
            ])
            ->withJsonPayload([
                'data' => [
                    'type' => 'experiment_users',
                    'attributes' => [
                        'user_signature' => $userSignature,
                    ],
                    'relationships' => [
                        'experiments' => [
                            'data' => [
                                'id' => $experimentId,
                                'type' => 'experiments',
                            ],
                        ],
                        'branches' => [
                            'data' => [
                                'id' => $branchId,
                                'type' => 'experiment_branches',
                            ]
                        ]
                    ],
                ],
            ])
            ->build();

        $this->requestExecutor->execute($request);
    }
}
