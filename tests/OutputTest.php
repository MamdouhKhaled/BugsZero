<?php

declare(strict_types=1);

namespace Tests;

use App\Enums\OutputEvent;
use App\Output;

it('Output with console adaptor', function () {
    $player_name = "Pet";
    $console_adaptor = new FakeOutputAdaptor();
    $output = new Output($console_adaptor);
    $output->message(OutputEvent::ADDED_PLAYER, $player_name);
    expect($console_adaptor->message)->toBe('Pet was added');
});