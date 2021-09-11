<?php
declare(strict_types = 1);

namespace Abrouter\Client\Tests\Unit\Builders\Payload;

use Abrouter\Client\Builders\Payload\ExperimentRunPayloadBuilder;
use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\Tests\Unit\TestCase;

class ExperimentRunPayloadBuilderTest extends TestCase
{
    /**
     * @var ExperimentRunPayloadBuilder $experimentRunPayloadBuilder
     */
    private ExperimentRunPayloadBuilder $experimentRunPayloadBuilder;
    
    public function setUp(): void
    {
        $this->experimentRunPayloadBuilder = $this->getContainer()->make(ExperimentRunPayloadBuilder::class);
    }
    
    public function testPayloadIsCorrect()
    {
        $userSignature = uniqid();
        $experimentId = uniqid();
        
        $payload = $this->experimentRunPayloadBuilder->build($userSignature, $experimentId);
        
        $this->assertInstanceOf(JsonPayload::class, $payload);
        $this->assertEquals($payload->getPayload(), [
            'data' => [
                'type'          => 'experiment-run',
                'attributes'    => [
                    'userSignature' => $userSignature,
                ],
                'relationships' => [
                    'experiment' => [
                        'data' => [
                            'id'   => $experimentId,
                            'type' => 'experiments',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
