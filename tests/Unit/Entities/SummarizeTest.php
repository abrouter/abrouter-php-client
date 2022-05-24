<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Entities;

use Abrouter\Client\DTO\BaseEventDTO;
use Abrouter\Client\Entities\Summarize;
use Abrouter\Client\DTO\SummarizeEventDTO;
use Abrouter\Client\Tests\Unit\TestCase;

class SummarizeTest extends TestCase
{
    /**
     * @return void
     */
    public function testStatistics()
    {
        $date = (new \DateTime())->format('Y-m-d');
        $incrementEventDTO = new SummarizeEventDTO((string)mt_rand(1, 100), new BaseEventDTO(
            'owner_' . uniqid(),
            'temporary_user_' . uniqid(),
            'user_' . uniqid(),
            'new_event',
            'new_tag',
            'abrouter',
            [],
            '255.255.255.255',
            $date
        ));
        $increment = new Summarize(
            $incrementEventDTO->getBaseEventDTO()->getEvent(),
            $incrementEventDTO->getValue()
        );
        $this->assertEquals($increment->isSuccessful(), true);
    }
}
