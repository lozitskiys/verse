<?php

namespace Verse;

interface Route
{
    function path(): string;

    function method(): string;

    function action(): string;
}