<?php

declare(strict_types=1);

namespace Abrouter\Client\RemoteEntity\Repositories;

use Abrouter\Client\Builders\RequestBuilder;
use Abrouter\Client\Builders\UrlBuilder;
use Abrouter\Client\RemoteEntity\Collections\ExperimentBranchesCollection;
use Abrouter\Client\Config\Accessors\TokenConfigAccessor;
use Abrouter\Client\Http\RequestExecutor;
use Abrouter\Client\Transformers\BranchesRequestTransformer;

class ExperimentBranchesRepository
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
     * @var BranchesRequestTransformer
     */
    private BranchesRequestTransformer $branchesRequestTransformer;

    public function __construct(
        UrlBuilder $urlBuilder,
        RequestBuilder $requestBuilder,
        TokenConfigAccessor $tokenConfigAccessor,
        RequestExecutor $requestExecutor,
        BranchesRequestTransformer $branchesRequestTransformer
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->requestBuilder = $requestBuilder;
        $this->tokenConfigAccessor = $tokenConfigAccessor;
        $this->requestExecutor = $requestExecutor;
        $this->branchesRequestTransformer = $branchesRequestTransformer;
    }

    public function getByExperimentAlias(string $experimentAlias): ExperimentBranchesCollection
    {
        $request = $this->requestBuilder
            ->get()
            ->url($this->urlBuilder->fetchBranchesUri($experimentAlias)->build())
            ->withHeaders([
                'Authorization' => $this->tokenConfigAccessor->getToken()
            ])
            ->build();

        $response = $this->requestExecutor->execute($request);

        return $this->branchesRequestTransformer->transform($response);
    }

    public function getBranchIdByUid(string $experimentAlias, string $branchUid): ?string
    {
        $branches = $this->getByExperimentAlias($experimentAlias);
        $branchId = null;
        foreach ($branches->getExperimentBranches() as $branch) {
            if ($branch->getUid() === $branchUid) {
                $branchId = $branchUid;
            }
        }

        return $branchId;
    }
}
