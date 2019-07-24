<?php

namespace Verse\Response;

use Verse\Response;

class RespRedirect implements Response
{
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
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
