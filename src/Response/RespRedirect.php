<?php

namespace Verse\Response;

use Verse\Response;

class RespRedirect implements Response
{
    public function __construct(private string $url)
    {
    }

    public function headers(): array
    {
        return ['Location: ' . $this->url];
    }

    public function body(): string
    {
        return '';
    }
}
