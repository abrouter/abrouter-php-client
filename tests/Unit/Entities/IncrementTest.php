<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Entities;

use Abrouter\Client\DTO\BaseEventDTO;
use Abrouter\Client\Entities\SentEvent;
use Abrouter\Client\DTO\IncrementEventDTO;
use Abrouter\Client\DTO\SummarizeEventDTO;
use Abrouter\Client\Tests\Unit\TestCase;

class IncrementTest extends TestCase
{
    /**
     * @return void
     */
    public function testIncrementStatistics()
    {
        $date = (new \DateTime())->format('Y-m-d');
        $incrementEventDTO = new IncrementEventDTO(new BaseEventDTO(
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
        $increment = new SentEvent(
            $incrementEventDTO->getBaseEventDTO()->getEvent()
        );
        $this->assertEquals($increment->isSuccessful(), true);
    }

    public function testSummarizeStatistics()
    {
        $date = (new \DateTime())->format('Y-m-d');
        $summarizeEventDTO = new SummarizeEventDTO((string)mt_rand(1,100) ,new BaseEventDTO(
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
        $summarize = new SentEvent(
            $summarizeEventDTO->getBaseEventDTO()->getEvent()
        );
        $this->assertEquals($summarize->isSuccessful(), true);
    }
}
