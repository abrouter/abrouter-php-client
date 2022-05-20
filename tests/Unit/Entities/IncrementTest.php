<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Entities;

use Abrouter\Client\DTO\BaseEventDTO;
use Abrouter\Client\Entities\Increment;
use Abrouter\Client\DTO\IncrementEventDTO;
use Abrouter\Client\Tests\Unit\TestCase;

class IncrementTest extends TestCase
{
    /**
     * @return void
     */
    public function testStatistics()
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
        $increment = new Increment(
            $incrementEventDTO->getBaseEventDTO()->getEvent()
        );
        $this->assertEquals($increment->isSuccessful(), true);
    }
}
