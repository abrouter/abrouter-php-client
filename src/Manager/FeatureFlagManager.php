<?php

declare(strict_types=1);

namespace Abrouter\Client\Manager;

use Abrouter\Client\Builders\Payload\FeatureFlagRunPayloadBuilder;
use Abrouter\Client\Requests\RunFeatureFlagRequest;
use Abrouter\Client\Transformers\RunFeatureFlagRequestTransformer;

class FeatureFlagManager
{
    /**
     * @var RunFeatureFlagRequest
     */
    private RunFeatureFlagRequest $runFeatureFlagRequest;

    /**
     * @var FeatureFlagRunPayloadBuilder
     */
    private FeatureFlagRunPayloadBuilder $featureFlagRunPayloadBuilder;

    /**
     * @var RunFeatureFlagRequestTransformer
     */
    private RunFeatureFlagRequestTransformer $runFeatureFlagRequestTransformer;

    public function __construct(
        RunFeatureFlagRequest $runFeatureFlagRequest,
        FeatureFlagRunPayloadBuilder $featureFlagRunPayloadBuilder,
        RunFeatureFlagRequestTransformer $runFeatureFlagRequestTransformer
    ) {
        $this->runFeatureFlagRequest = $runFeatureFlagRequest;
        $this->featureFlagRunPayloadBuilder = $featureFlagRunPayloadBuilder;
        $this->runFeatureFlagRequestTransformer = $runFeatureFlagRequestTransformer;
    }

    /**
     * @param string $id
     * @return bool
     */

    public function run(string $id): bool
    {
        $payload = $this->featureFlagRunPayloadBuilder->build($id);
        $response = $this->runFeatureFlagRequest->runFeatureFlag($payload);
        $runFeatureFlag = $this->runFeatureFlagRequestTransformer->transform($response);

        return $runFeatureFlag;
    }
}
