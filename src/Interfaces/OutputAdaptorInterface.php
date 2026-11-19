<?php

namespace App\Interfaces;

interface OutputAdaptorInterface
{
    public function write(string $message): void;
}