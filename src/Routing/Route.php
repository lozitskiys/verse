<?php

namespace Verse\Routing;

interface Route
{
    public function path(): string;

    public function method(): string;

    public function action(): string;

    public function token(string $key, bool $strict = true);
}
