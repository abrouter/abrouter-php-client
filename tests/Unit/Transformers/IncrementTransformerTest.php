<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Transformers;

use Abrouter\Client\DTO\BaseEventDTO;
use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Entities\Increment;
use Abrouter\Client\Tests\Unit\TestCase;
use Abrouter\Client\Transformers\IncrementRequestTransformer;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use AbRouter\Client\DTO\IncrementEventDTO;

class IncrementTransformerTest extends TestCase
{
    /**
     * @var IncrementRequestTransformer $incrementRequestTransformer
     */
    private IncrementRequestTransformer $incrementRequestTransformer;

    public function setUp(): void
    {
        $this->incrementRequestTransformer = $this->getContainer()
                ->make(IncrementRequestTransformer::class);
    }

    /**
     * @return void
     * @throws InvalidJsonApiResponseException
     */
    public function testTransform()
    {
        $date = (new \DateTime())->format('Y-m-d');
        $incrementEventDTO = new IncrementEventDTO(new BaseEventDTO(
            'owner_12345',
            'temporary_user_12345',
            'user_12345',
            'new_event',
            'new_tag',
            'abrouter',
            [],
            '255.255.255.255',
            $date
        ));

        $increment = $this->incrementRequestTransformer->transform(
            new Response(
                [
                    'data' => [
                        'id' => uniqid(),
                        'type' => 'events',
                        'attributes' => [
                            'user_id' => $incrementEventDTO->getBaseEventDTO()->getUserId(),
                            'event' => $incrementEventDTO->getBaseEventDTO()->getEvent(),
                            'tag' => $incrementEventDTO->getBaseEventDTO()->getTag(),
                            'referrer' => $incrementEventDTO->getBaseEventDTO()->getReferrer(),
                            'ip' => $incrementEventDTO->getBaseEventDTO()->getIp(),
                            'meta' => $incrementEventDTO->getBaseEventDTO()->getMeta(),
                            'created_at' => $incrementEventDTO->getBaseEventDTO()->getCreatedAt()
                        ],
                    ]
                ]
            )
        );

        $this->assertInstanceOf(Increment::class, $increment);
        $this->assertEquals($increment->isSuccessful(), true);
    }

    /**
     * @return void
     * @throws InvalidJsonApiResponseException
     */
    public function testException()
    {
        $this->expectException(InvalidJsonApiResponseException::class);
        $this->incrementRequestTransformer->transform(
            new Response(
                [
                    'data' => [],
                ]
            )
        );
    }
}
