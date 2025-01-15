<?php

namespace App\Models;

use ArrayAccess;
use Countable;
use Exception;
use IteratorAggregate;
use Traversable;

class Collection implements Countable, ArrayAccess, IteratorAggregate
{
    public function __construct(protected array $items)
    {
    }

    public function map()
    {
    }

    public function filter()
    {
    }

    public static function make(array $items)
    {
        return new static($items);
    }

    public function count()
    {
        return count($this->items);
    }

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }
}