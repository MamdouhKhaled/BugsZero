<?php

namespace App;

use App\Adaptors\ConsoleOutputAdaptor;

class GameRunner
{

    public static function runGame()
    {


        $playerOne = new Player('Chet');
        $playerTwo = new Player('Pat');
        $playerThree = new Player('Sue');
        $aGame = new Game($playerOne, $playerTwo, new QuestionDeck(), new Output(new ConsoleOutputAdaptor()));


        $aGame->add($playerThree);


        do {
            $currentPlayer = $aGame->player;
            $aGame->roll(rand(0, 5) + 1);
            if (rand(0, 9) == 7) {
                $aGame->wrongAnswer();
            } else {
                $aGame->wasCorrectlyAnswered();
            }


        } while (!$aGame->didPlayerWin($currentPlayer));
    }
}



