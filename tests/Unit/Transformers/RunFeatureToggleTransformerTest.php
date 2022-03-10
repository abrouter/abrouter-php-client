<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Transformers;

use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Tests\Unit\TestCase;
use Abrouter\Client\Transformers\RunFeatureFlagRequestTransformer;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;

class RunFeatureToggleTransformerTest extends TestCase
{
    /**
     * @var RunFeatureFlagRequestTransformer $runFeatureFlagRequestTransformer
     */
    private RunFeatureFlagRequestTransformer $runFeatureFlagRequestTransformer;

    public function setUp(): void
    {
        $this->runFeatureFlagRequestTransformer = $this->getContainer()->make(RunFeatureFlagRequestTransformer::class);
    }

    /**
     * @throws InvalidJsonApiResponseException
     */
    public function testTransform()
    {
        $runExperiment = $this->runFeatureFlagRequestTransformer->transform(new Response([
            'data' => [
                'type' => 'feature-toggle-result',
                'id' => uniqid(),
                'attributes' => [
                    'is_enabled' => true
                ],
            ],
        ]));

        $this->assertEquals($runExperiment, true);
    }

    /**
     * @throws InvalidJsonApiResponseException
     */
    public function testException()
    {
        $this->expectException(InvalidJsonApiResponseException::class);
        $this->runFeatureFlagRequestTransformer->transform(new Response([
            'data' => [],
        ]));
    }
}
