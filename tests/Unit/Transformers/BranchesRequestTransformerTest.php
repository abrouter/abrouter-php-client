<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Transformers;

use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\RemoteEntity\Collections\ExperimentBranchesCollection;
use Abrouter\Client\Tests\Unit\TestCase;
use Abrouter\Client\Transformers\BranchesRequestTransformer;

class BranchesRequestTransformerTest extends TestCase
{
    /**
     * @var BranchesRequestTransformer
     */
    private $branchesRequestTransformer;

    public function setUp(): void
    {
        $this->branchesRequestTransformer = $this->getContainer()->make(BranchesRequestTransformer::class);
    }

    /**
     * @throws InvalidJsonApiResponseException
     */
    public function testTransform()
    {
        $responseJson = [
            'data' => [
                0 => [
                    'id' => '8F761000-0000-0000-0000C828',
                    'type' => 'experiments',
                    'attributes' => [
                        'name' => 'price',
                        'uid' => 'price',
                        'alias' => 'price',
                        'config' => [
                        ],
                        'is_enabled' => true,
                        'is_feature_toggle' => false,
                    ],
                    'relationships' => [
                        'owner' => [
                            'data' => [
                                'id' => '8538A000-0000-0000-00005B7D',
                                'type' => 'users',
                            ],
                        ],
                        'branches' => [
                            'data' => [
                                0 => [
                                    'id' => '2A7C2000-0000-0000-00005D3D',
                                    'type' => 'experiment_branches',
                                ],
                                1 => [
                                    'id' => 'A62D3000-0000-0000-00005D3D',
                                    'type' => 'experiment_branches',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'meta' => [
                'token' => '',
            ],
            'included' => [
                0 => [
                    'id' => '2A7C2000-0000-0000-00005D3D',
                    'type' => 'experiment_branches',
                    'attributes' => [
                        'name' => 'low',
                        'uid' => 'low',
                        'percent' => 50,
                        'config' => [
                        ],
                    ],
                    'relationships' => [
                        'experiment' => [
                            'data' => [
                                'id' => '8F761000-0000-0000-0000C828',
                                'type' => 'users',
                            ],
                        ],
                    ],
                ],
                1 => [
                    'id' => 'A62D3000-0000-0000-00005D3D',
                    'type' => 'experiment_branches',
                    'attributes' => [
                        'name' => 'original',
                        'uid' => 'original',
                        'percent' => 50,
                        'config' => [
                        ],
                    ],
                    'relationships' => [
                        'experiment' => [
                            'data' => [
                                'id' => '8F761000-0000-0000-0000C828',
                                'type' => 'users',
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $experimentBranchesCollection = $this->branchesRequestTransformer->transform(new Response($responseJson));

        $expId = '8F761000-0000-0000-0000C828';
        $this->assertInstanceOf(ExperimentBranchesCollection::class, $experimentBranchesCollection);
        $this->assertEquals($experimentBranchesCollection->getExperimentId(), $expId);
        $this->assertEquals(sizeof($experimentBranchesCollection->getExperimentBranches()), 2);

        $this->assertEquals($experimentBranchesCollection->getExperimentBranches()[0]->getUid(), 'low');
        $this->assertEquals($experimentBranchesCollection->getExperimentBranches()[0]->getPercentage(), 50);
        $this->assertEquals($experimentBranchesCollection->getExperimentBranches()[0]->getExperimentId(), $expId);
        $this->assertEquals(
            $experimentBranchesCollection->getExperimentBranches()[0]->getId(),
            '2A7C2000-0000-0000-00005D3D',
        );

        $this->assertEquals($experimentBranchesCollection->getExperimentBranches()[1]->getUid(), 'original');
        $this->assertEquals($experimentBranchesCollection->getExperimentBranches()[1]->getPercentage(), 50);
        $this->assertEquals($experimentBranchesCollection->getExperimentBranches()[1]->getExperimentId(), $expId);
        $this->assertEquals(
            $experimentBranchesCollection->getExperimentBranches()[1]->getId(),
            'A62D3000-0000-0000-00005D3D',
        );
    }

    /**
     * @throws InvalidJsonApiResponseException
     */
    public function testEmptyResponse()
    {
        $t = $this->branchesRequestTransformer->transform(new Response([
            'data' => [
            ],
        ]));

        $this->assertNull($t->getExperimentId());
        $this->assertEquals(sizeof($t->getExperimentBranches()), 0);
    }


    /**
     * @throws InvalidJsonApiResponseException
     */
    public function testException()
    {
        $this->expectException(InvalidJsonApiResponseException::class);
        $this->branchesRequestTransformer->transform(new Response([
            'data' => [
                [
                    'id' => 'test',
                ]
            ],
        ]));
    }
}
