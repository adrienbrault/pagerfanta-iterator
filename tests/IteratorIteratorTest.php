<?php

namespace AdrienBrault\PagerfantaIterator\Tests;

use AdrienBrault\PagerfantaIterator\IteratorIterator;
use PHPUnit\Framework\TestCase;

class IteratorIteratorTest extends TestCase
{
    public function test()
    {
        $iteratorIterator = new IteratorIterator(new \ArrayIterator(array(
            new \ArrayIterator(array('hello', 'world')),
            new \ArrayIterator(array('wow', 'such', 'php')),
        )));
        $this->assertSame(
            array(
                'hello',
                'world',
                'wow',
                'such',
                'php',
            ),
            iterator_to_array($iteratorIterator)
        );
    }
}
