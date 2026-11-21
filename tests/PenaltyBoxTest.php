<?php
declare(strict_types=1);

namespace Tests;

use App\Adaptors\ConsoleOutputAdaptor;
use App\Game;
use App\Output;
use App\Player;
use App\QuestionDeck;

it('player outside Penalty Box earns a coin after correct answer', function () {
    $playerOne = new Player('Chet');
    $playerTwo = new Player('Pat');
    $aGame = new Game($playerOne, $playerTwo, new QuestionDeck(), new Output(new ConsoleOutputAdaptor()));
    $aGame->roll(2);
    $aGame->wasCorrectlyAnswered();
    expect(2)
        ->toBe($playerOne->currentPlace())
        ->and(false)->toBe($playerOne->isInPenaltyBox())
        ->and(1)->toBe($playerOne->coins());
});

it('player in Penalty Box cannot move or earn a coin after even roll', function () {
    $playerOne = new Player('Chet');
    $playerTwo = new Player('Pat');
    $aGame = new Game($playerOne, $playerTwo, new QuestionDeck(), new Output(new ConsoleOutputAdaptor()));
    $playerOne->goToPenaltyBox();
    $aGame->roll(2);
    expect(0)
        ->toBe($playerOne->currentPlace())
        ->and(true)->toBe($playerOne->isInPenaltyBox())
        ->and(0)->toBe($playerOne->coins());
});

it('player leaves Penalty Box and earns a coin after odd roll and correct answer', function () {
    $playerOne = new Player('Chet');
    $playerTwo = new Player('Pat');
    $aGame = new Game($playerOne, $playerTwo, new QuestionDeck(), new Output(new ConsoleOutputAdaptor()));
    $playerOne->goToPenaltyBox();
    $aGame->roll(3);
    $aGame->wasCorrectlyAnswered();
    expect(3)
        ->toBe($playerOne->currentPlace())
        ->and(1)->toBe($playerOne->coins())
        ->and(false)->toBe($playerOne->isInPenaltyBox());

});


it('player remains in Penalty Box and loses eligibility after wrong answer on odd roll', function () {
    $playerOne = new Player('Chet');
    $playerTwo = new Player('Pat');
    $aGame = new Game($playerOne, $playerTwo, new QuestionDeck(), new Output(new ConsoleOutputAdaptor()));
    $playerOne->goToPenaltyBox();
    $aGame->roll(3);
    $aGame->wrongAnswer();
    expect(3)
        ->toBe($playerOne->currentPlace())
        ->and(true)->toBe($playerOne->isInPenaltyBox())
        ->and(0)->toBe($playerOne->coins())
        ->and(false)->toBe($playerOne->isEligibleToLeavePenaltyBox());
});

it('determines if player is eligible to leave penalty box', function (
    bool $inPenalty,
    bool $canLeavePenaltyBox,
    bool $expected
) {
    $player = new Player('Chet');

    if ($inPenalty) {
        $player->goToPenaltyBox();
    }

    if ($canLeavePenaltyBox && $inPenalty) {
        $player->markAsEligibleToLeavePenaltyBox();
    }

    expect($expected)->toBe($player->isEligibleToLeavePenaltyBox());
})->with([
    [false, false, false],
    [true, false, false],
    [true, true, true],
]);
it('cannot mark player as eligible when not in penalty box', function () {
    $player = new Player('Chet');

    $player->markAsEligibleToLeavePenaltyBox();
})->throws(\LogicException::class);

it('cannot mark player as eligible to leave penalty box when not in penalty box', function () {
    $player = new Player('Chet');

    $player->markAsEligibleToLeavePenaltyBox();
})->throws(\LogicException::class);

it('resets player penalty box state after leaving penalty box', function () {
    $player = new Player('Chet');
    $player->goToPenaltyBox();
    $player->markAsEligibleToLeavePenaltyBox();
    $player->gettingOutFromPenaltyBox();
    expect(false)->toBe($player->isInPenaltyBox())
    ->and(false)->toBe($player->isEligibleToLeavePenaltyBox());
});