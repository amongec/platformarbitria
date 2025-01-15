<?php

namespace Tests;

use App\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase {
    
    function it_wraps_an_array_of_items(){

        $items = ['one', 'two', 'three'];
        $this->assertCount(3, Collection::make($items));

    }

    function it_mimics_an_array(){

        $items = ['one', 'two', 'three'];
        $collection = Collection::make($items);

            $this->assertEquals('one', $collection[0]);
            $this->assertEquals('two', $collection[1]);
            $this->assertEquals('three', $collection[2]);
    }

    function it_can_be_iterated(){

        $items = ['one', 'two', 'three'];

        $collection = Collection::make($items);

        $this->assertInstanceOf(IteratorAggregate::class, $collection);

        foreach($collection as $index => $items) {
            $this->assertEquals($items[$index],$item);
        }
    }

}
