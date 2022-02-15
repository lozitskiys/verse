<?php

namespace Verse\Service;

interface Mailer
{
    public function send(string $to, string $title, string $message): bool;
}
