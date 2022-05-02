<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Builders\Payload;

use Abrouter\Client\Builders\Payload\FeatureFlagRunPayloadBuilder;
use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\Tests\Unit\TestCase;

class FeatureFlagRunPayloadBuilderTest extends TestCase
{
    /**
     * @var FeatureFlagRunPayloadBuilder $featureFlagRunPayloadBuilder
     */
    private FeatureFlagRunPayloadBuilder $featureFlagRunPayloadBuilder;

    public function setUp(): void
    {
        $this->featureFlagRunPayloadBuilder = $this->getContainer()->make(FeatureFlagRunPayloadBuilder::class);
    }

    public function testPayloadIsCorrect()
    {
        $id = uniqid();

        $payload = $this->featureFlagRunPayloadBuilder->build($id);

        $this->assertInstanceOf(JsonPayload::class, $payload);
        $this->assertEquals($payload->getPayload(), [
            'data' => [
                'type'          => 'feature-toggles-run',
                'attributes'    => [
                    'userSignature' => "",
                ],
                'relationships' => [
                    'feature-toggle' => [
                        'data' => [
                            'id'   => $id,
                            'type' => 'feature-toggles',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
