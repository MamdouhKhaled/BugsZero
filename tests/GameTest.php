<?php
declare(strict_types=1);

namespace Tests;

use App\Game;
use App\GameRunner;
use App\Player;

test("Lock Downr", function () {
    srand(123455);
    ob_start();

    GameRunner::runGame();

    $actual = ob_get_contents();
    ob_end_clean();

    $expected = file_get_contents('approved.txt');
    $this->assertEquals($expected, $actual);
});

it('A Game could have 7 players', function () {
    $playerOne = new Player('Chet');
    $playerTwo = new Player('Pat');
    $aGame = new Game($playerOne, $playerTwo);
    foreach (range(1, 7) as $i) {
        $aGame->add(new Player("Player " . $i));
    }
})->throws(\Exception::class);

it('player will move with even step', function () {
    $playerOne = new Player('Chet');
    $playerTwo = new Player('Pat');
    $aGame = new Game($playerOne, $playerTwo);
    $aGame->roll(4);
    expect(4)->toBe($playerOne->currentPlace());
});

it('player will move with odd step while in Penalty Box', function () {
    $playerOne = new Player('Chet');
    $playerTwo = new Player('Pat');
    $aGame = new Game($playerOne, $playerTwo);
    $playerOne->goToPenaltyBox();
    $aGame->roll(3);
    expect(3)->toBe($playerOne->currentPlace())
        ->and(true)->toBe($playerOne->isInPenaltyBox());
});

it('player will move with odd step while in Penalty Box after correct answer', function () {
    $playerOne = new Player('Chet');
    $playerTwo = new Player('Pat');
    $aGame = new Game($playerOne, $playerTwo);
    $playerOne->goToPenaltyBox();
    $aGame->roll(3);
    $aGame->wasCorrectlyAnswered();
    expect(3)->toBe($playerOne->currentPlace())
        ->and(true)->toBe($playerOne->isInPenaltyBox());
});

it('player cannot move while in Penalty Box', function () {
    $playerOne = new Player('Chet');
    $playerTwo = new Player('Pat');
    $aGame = new Game($playerOne, $playerTwo);
    $playerOne->goToPenaltyBox();
    $aGame->roll(2);
    expect(0)->toBe($playerOne->currentPlace());
});
