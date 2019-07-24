<?php

namespace Verse;

interface Response
{
    public function headers(): array;

    public function body(): string;
}
