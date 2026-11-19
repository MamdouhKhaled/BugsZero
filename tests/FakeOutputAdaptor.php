<?php
declare(strict_types=1);

namespace Tests;

use App\Interfaces\OutputAdaptorInterface;

class FakeOutputAdaptor implements OutputAdaptorInterface
{
    public ?string $message = null;

    public function write(string $message): void
    {
        $this->message = $message;
    }
}