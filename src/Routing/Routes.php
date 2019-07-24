<?php

namespace Verse\Routing;

use IteratorAggregate;
use Traversable;

interface Routes extends IteratorAggregate
{
    /**
     * @return Traversable|Route[]
     */
    public function getIterator(): Traversable;
}
