<?php

namespace Abrouter\Client\Tests\Unit\Managers;

use Abrouter\Client\Builders\Payload\FeatureFlagRunPayloadBuilder;
use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Entities\Client\ResponseInterface;
use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\Manager\FeatureFlagManager;
use Abrouter\Client\RemoteEntity\Cache\Cacher;
use Abrouter\Client\Tests\Unit\TestCase;
use Abrouter\Client\Requests\RunFeatureFlagRequest;
use Abrouter\Client\Transformers\RunFeatureFlagRequestTransformer;

class FeatureToggleManagerTest extends TestCase
{
    public function testRunFeatureFlag()
    {
        $this->bindConfig();

        $runFeatureFlagRequest = new class () extends RunFeatureFlagRequest {
            public function __construct()
            {
            }

            public function runFeatureFlag(JsonPayload $jsonPayload): ResponseInterface
            {
                return new Response([
                    'data' => [
                        'id' => uniqid(),
                        'type' => 'feature-toggle-result',
                        'attributes' => [
                            'is_enabled' => true
                        ],
                    ]
                ]);
            }
        };

        $arguments = $this->createArgumentsFor(FeatureFlagManager::class);
        $arguments[0] = $runFeatureFlagRequest;

        $experimentManager = new FeatureFlagManager(...$arguments);
        $id = uniqid();
        $runFeatureFlagEntity = $experimentManager->run($id);

        $this->assertEquals($runFeatureFlagEntity, true);
    }
}
