<?php
declare(strict_types=1);

namespace Tests;

use App\Adaptors\ConsoleOutputAdaptor;
use App\Game;
use App\GameRunner;
use App\Output;
use App\Player;
use App\QuestionDeck;
//// this Test will be fail at end of refactor
//test("Lock Downr", function () {
//    srand(123455);
//    ob_start();
//
//    GameRunner::runGame();
//
//    $actual = ob_get_contents();
//    ob_end_clean();
//
//    $expected = file_get_contents('approved.txt');
//    $this->assertEquals($expected, $actual);
//});

beforeEach(function () {
    $this->playerOne = new Player('Chet');
    $this->playerTwo = new Player('Pat');
    $this->aGame = new Game($this->playerOne, $this->playerTwo, new QuestionDeck(), new Output(new ConsoleOutputAdaptor()));

});

it('A Game could have 7 players', function () {
    foreach (range(1, 7) as $i) {
        $this->aGame->add(new Player("Player " . $i));
    }
})->throws(\Exception::class);

it('player will move with even step', function () {
    $this->aGame->roll(4);
    expect(4)->toBe($this->playerOne->currentPlace());
});

it('player will move with odd step while in Penalty Box', function () {
    $this->playerOne->goToPenaltyBox();
    $this->aGame->roll(3);
    expect(3)->toBe($this->playerOne->currentPlace())
        ->and(true)->toBe($this->playerOne->isInPenaltyBox());
});

it('player will move with odd step while in Penalty Box after correct answer', function () {
    $this->playerOne->goToPenaltyBox();
    $this->aGame->roll(3);
    $this->aGame->wasCorrectlyAnswered();
    expect(3)->toBe($this->playerOne->currentPlace())
        ->and(false)->toBe($this->playerOne->isInPenaltyBox());
});

it('player cannot move while in Penalty Box', function () {
    $this->playerOne->goToPenaltyBox();
    $this->aGame->roll(2);
    expect(0)->toBe($this->playerOne->currentPlace());
});

describe('can not make answer without roll', function (){
    it('correct answer', function () {
        $this->aGame->wasCorrectlyAnswered();
    })->throws(\Exception::class);

    it('wrong answer', function () {
        $this->aGame->wrongAnswer();
    })->throws(\Exception::class);
});
