<?php
declare(strict_types=1);

namespace Tests;

use App\GameRunner;

test("Lock Downr", function () {
    srand(123455);
    ob_start();

    GameRunner::runGame();

    $actual = ob_get_contents();
    ob_end_clean();

    $expected = file_get_contents('approved.txt');
    $this->assertEquals($expected, $actual);
});