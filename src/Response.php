<?php

namespace Verse;

interface Response
{
    function headers(): array;

    function body(): string;
}
