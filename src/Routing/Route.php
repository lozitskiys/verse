<?php

namespace Verse\Routing;

interface Route
{
    function path(): string;

    function method(): string;

    function action(): string;

    function token(string $key);
}
