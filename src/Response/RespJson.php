<?php

namespace Verse\Response;

use Verse\Response;

class RespJson implements Response
{
    private $result;
    private $headers;

    public function __construct(array $result, array $headers = [])
    {
        $headers[] = 'Content-type: application/json; charset=UTF-8';

        $this->result = $result;
        $this->headers = $headers;
    }

    public function body(): string
    {
        return json_encode($this->result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function headers(): array
    {
        return $this->headers;
    }
}
