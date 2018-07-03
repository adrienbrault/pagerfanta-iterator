<?php

namespace AdrienBrault\PagerfantaIterator\Tests;

use AdrienBrault\PagerfantaIterator\IteratorIterator;
use AdrienBrault\PagerfantaIterator\PagerfantaIterator;
use Pagerfanta\Pagerfanta;
use PHPUnit\Framework\TestCase;

class PagerfantaIteratorTest extends TestCase
{
    public function test()
    {
        $adapterProphecy = $this->prophesize('Pagerfanta\Adapter\AdapterInterface');
        $adapterProphecy->getNbResults()->willReturn(18);
        $adapterProphecy->getSlice(0, 5)->willReturn(range(0, 4))->shouldBeCalledTimes(1);
        $adapterProphecy->getSlice(5, 5)->willReturn(range(5, 9))->shouldBeCalledTimes(1);
        $adapterProphecy->getSlice(10, 5)->willReturn(range(10, 14))->shouldBeCalledTimes(1);
        $adapterProphecy->getSlice(15, 5)->willReturn(range(15, 18))->shouldBeCalledTimes(1);

        $pager = new Pagerfanta($adapterProphecy->reveal());
        $pager->setMaxPerPage(5);

        $pagerIterator = new IteratorIterator(new PagerfantaIterator($pager));
        $this->assertSame(
            range(0, 18),
            iterator_to_array($pagerIterator)
        );
    }

    public function testStartPage()
    {
        $adapterProphecy = $this->prophesize('Pagerfanta\Adapter\AdapterInterface');
        $adapterProphecy->getNbResults()->willReturn(18);
        $adapterProphecy->getSlice(5, 5)->willReturn(range(5, 9))->shouldBeCalledTimes(1);
        $adapterProphecy->getSlice(10, 5)->willReturn(range(10, 14))->shouldBeCalledTimes(1);
        $adapterProphecy->getSlice(15, 5)->willReturn(range(15, 18))->shouldBeCalledTimes(1);

        $pager = new Pagerfanta($adapterProphecy->reveal());
        $pager->setMaxPerPage(5);

        $pagerIterator = new IteratorIterator(new PagerfantaIterator($pager, 2));
        $this->assertSame(
            range(5, 18),
            iterator_to_array($pagerIterator)
        );
    }
    
    public function testIterateOverPagesFactory()
    {
        $adapterProphecy = $this->prophesize('Pagerfanta\Adapter\AdapterInterface');
        $adapterProphecy->getNbResults()->willReturn(18);
        $adapterProphecy->getSlice(0, 5)->willReturn(range(0, 4))->shouldBeCalledTimes(1);
        $adapterProphecy->getSlice(5, 5)->willReturn(range(5, 9))->shouldBeCalledTimes(1);
        $adapterProphecy->getSlice(10, 5)->willReturn(range(10, 14))->shouldBeCalledTimes(1);
        $adapterProphecy->getSlice(15, 5)->willReturn(range(15, 18))->shouldBeCalledTimes(1);

        $pager = new Pagerfanta($adapterProphecy->reveal());
        $pager->setMaxPerPage(5);

        $pagerIterator = new IteratorIterator(PagerfantaIterator::iterateOverPages($pager));
        $this->assertSame(
            range(0, 18),
            iterator_to_array($pagerIterator)
        );
    }

    public function testIterateOverElementsFactory()
    {
        $adapterProphecy = $this->prophesize('Pagerfanta\Adapter\AdapterInterface');
        $adapterProphecy->getNbResults()->willReturn(18);
        $adapterProphecy->getSlice(0, 5)->willReturn(range(0, 4))->shouldBeCalledTimes(1);
        $adapterProphecy->getSlice(5, 5)->willReturn(range(5, 9))->shouldBeCalledTimes(1);
        $adapterProphecy->getSlice(10, 5)->willReturn(range(10, 14))->shouldBeCalledTimes(1);
        $adapterProphecy->getSlice(15, 5)->willReturn(range(15, 18))->shouldBeCalledTimes(1);

        $pager = new Pagerfanta($adapterProphecy->reveal());
        $pager->setMaxPerPage(5);

        $pagerIterator = PagerfantaIterator::iterateOverElements($pager);
        $this->assertSame(
            range(0, 18),
            iterator_to_array($pagerIterator)
        );
    }
}
