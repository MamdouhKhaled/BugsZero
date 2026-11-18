<?php

use App\Game;
use App\Player;
use App\QuestionDeck;

it('player outside Penalty Box earns a coin after correct answer', function () {
    $playerOne = new Player('Chet');
    $playerTwo = new Player('Pat');
    $aGame = new Game($playerOne, $playerTwo,new QuestionDeck());
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
    $aGame = new Game($playerOne, $playerTwo,new QuestionDeck());
    $playerOne->goToPenaltyBox();
    $aGame->roll(2);
    $aGame->wasCorrectlyAnswered();
    expect(0)
        ->toBe($playerOne->currentPlace())
        ->and(true)->toBe($playerOne->isInPenaltyBox())
        ->and(0)->toBe($playerOne->coins());
});

it('player leaves Penalty Box and earns a coin after odd roll and correct answer', function () {
    $playerOne = new Player('Chet');
    $playerTwo = new Player('Pat');
    $aGame = new Game($playerOne, $playerTwo,new QuestionDeck());
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
    $aGame = new Game($playerOne, $playerTwo,new QuestionDeck());
    $playerOne->goToPenaltyBox();
    $aGame->roll(3);
    $aGame->wrongAnswer();
    expect(3)
        ->toBe($playerOne->currentPlace())
        ->and(true)->toBe($playerOne->isInPenaltyBox())
        ->and(0)->toBe($playerOne->coins())
        ->and(false)->toBe($playerOne->isEligibleToLeavePenaltyBox());
});