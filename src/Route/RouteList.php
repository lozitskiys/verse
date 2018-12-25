<?php

namespace Verse\Route;

use Verse\Route;
use Traversable;

interface RouteList extends \IteratorAggregate
{
    /**
     * @return Traversable|Route[]
     */
    function getIterator(): Traversable;
}