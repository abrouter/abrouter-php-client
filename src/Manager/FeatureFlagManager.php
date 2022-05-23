<?php

declare(strict_types=1);

namespace Abrouter\Client\Manager;

use Abrouter\Client\Builders\Payload\FeatureFlagRunPayloadBuilder;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\Exceptions\RunFeatureFlagRequestException;
use Abrouter\Client\RemoteEntity\Cache\Cacher;
use Abrouter\Client\RemoteEntity\Entities\FeatureFlagRan;
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

    /**
     * @var Cacher
     */
    private Cacher $cacher;

    /**
     * @param RunFeatureFlagRequest $runFeatureFlagRequest
     * @param FeatureFlagRunPayloadBuilder $featureFlagRunPayloadBuilder
     * @param RunFeatureFlagRequestTransformer $runFeatureFlagRequestTransformer
     * @param Cacher $cacher
     */
    public function __construct(
        RunFeatureFlagRequest $runFeatureFlagRequest,
        FeatureFlagRunPayloadBuilder $featureFlagRunPayloadBuilder,
        RunFeatureFlagRequestTransformer $runFeatureFlagRequestTransformer,
        Cacher $cacher
    ) {
        $this->runFeatureFlagRequest = $runFeatureFlagRequest;
        $this->featureFlagRunPayloadBuilder = $featureFlagRunPayloadBuilder;
        $this->runFeatureFlagRequestTransformer = $runFeatureFlagRequestTransformer;
        $this->cacher = $cacher;
    }

    /**
     * @param string $id
     * @return bool
     * @throws InvalidJsonApiResponseException
     * @throws RunFeatureFlagRequestException
     */
    public function run(string $id): bool
    {
        $featureFlagRun = function () use ($id) {
            $payload = $this->featureFlagRunPayloadBuilder->build($id);
            $response = $this->runFeatureFlagRequest->runFeatureFlag($payload);
            $runFeatureFlag = $this->runFeatureFlagRequestTransformer->transform($response);

            return new FeatureFlagRan($runFeatureFlag);
        };

        if ($this->cacher !== null && $this->cacher->isEnabled()) {
            /**
             * @var FeatureFlagRan $object
             */
             $object = $this->cacher->fetch(
                 $id,
                 'feature-flag',
                 300,
                 $featureFlagRun
             );
             return $object->isEnabled();
        }

        return $featureFlagRun()->isEnabled();
    }
}
