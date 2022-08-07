<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\DB;

use Abrouter\Client\DB\RunTimeCache;
use Abrouter\Client\Tests\Unit\TestCase;

class RunTimeCacheTest extends TestCase
{
    public function testSet()
    {
        $value = uniqid();
        RunTimeCache::set('test1', $value);

        $this->assertEquals(RunTimeCache::get('test1'), $value);
    }

    public function testGetEmpty()
    {
        $this->assertNull(RunTimeCache::get('test'));
    }

    public function testRemove()
    {
        RunTimeCache::set('test', 'test');
        RunTimeCache::removeIfExists('test');

        $this->assertNull(RunTimeCache::get('test'));
    }

    public function testFlushAll()
    {
        RunTimeCache::set('test12', 'test');
        RunTimeCache::flushAll();
        $this->assertNull(RunTimeCache::get('test12'));
    }
}
