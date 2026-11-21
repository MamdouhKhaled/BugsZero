<?php

use App\Player;

it('can init player with default value', function () {
    $player = new Player('Chet');
    expect($player)->toBeInstanceOf(Player::class)
        ->and('Chet')->toBe($player->name)
        ->and(0)->toBe($player->coins())
        ->and(0)->toBe($player->currentPlace())
        ->and(false)->toBe($player->isEligibleToLeavePenaltyBox())
        ->and(false)->toBe($player->isInPenaltyBox());
});

it('Add Coin to Player', function () {
    $player = new Player('Chet');
    $player->addOneCoin();
    expect(1)->toBe($player->coins());
});

it('Player can move any number from 1 to 6', function ($place) {
    $player = new Player('Chet');
    $player->moveForwardBy($place);
    expect($place)->toBe($player->currentPlace());
})->with([1, 2, 3, 4, 5, 6]);

describe('Player can not move any number', function () {
    it ('less than 1', function ($place) {
        $player = new Player('Chet');
        $player->moveForwardBy($place);
    })->with([0,-10])->throws(Exception::class);

    it ('more than 6', function ($place) {
        $player = new Player('Chet');
        $player->moveForwardBy($place);
    })->with([7,8])->throws(Exception::class);

});