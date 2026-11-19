<?php

namespace App\Adaptors;

use App\Interfaces\OutputAdaptorInterface;

class ConsoleOutputAdaptor implements OutputAdaptorInterface
{

    public function write(string $message): void
    {
        echo $message."\n";
    }
}