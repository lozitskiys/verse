<?php

namespace Verse\Response;

use Verse\Response;

class RespHtml implements Response
{
    private $result;
    private $headers;

    public function __construct(string $result, array $headers = [])
    {
        $headers[] = 'Content-type: text/html; charset=UTF-8';

        $this->result = $result;
        $this->headers = $headers;
    }

    public function body(): string
    {
        return $this->result;
    }

    public function headers(): array
    {
        return $this->headers;
    }
}