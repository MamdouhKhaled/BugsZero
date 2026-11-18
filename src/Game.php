<?php

namespace App;
function echoln($string)
{
    echo $string . "\n";
}

class Game
{
    private array $players = [];


    var $currentPlayer = 0;
    public Player $player;
    var $isGettingOutOfPenaltyBox;

    function __construct(Player $playerOne, Player $playerTwo, private QuestionDeck $deck)
    {
        $this->add($playerOne);
        $this->add($playerTwo);
    }
    function add(Player $player)
    {
        if ($this->howManyPlayers() >= 6) {
            throw new \Exception('A Game Cannot have more than six players');
        }
        if (empty($this->player)) {
            $this->player = $player;
        }
        array_push($this->players, $player);

        echoln($player->name . " was added");
        echoln("They are player number " . $this->howManyPlayers());
        return true;
    }

    function howManyPlayers()
    {
        return count($this->players);
    }

    function roll($roll)
    {
        $this->player->cannotLeavePenaltyBox();
        echoln($this->player->name . " is the current player");
        echoln("They have rolled a " . $roll);
        if ($this->player->isInPenaltyBox() && $roll % 2 == 0) {
            echoln($this->player->name . " is not getting out of the penalty box");
            $this->isGettingOutOfPenaltyBox = false;
            return;
        }

        if ($this->player->isInPenaltyBox()) {
            $this->isGettingOutOfPenaltyBox = true;
//            $this->player->markAsEligibleToLeavePenaltyBox();
            echoln($this->player->name . " is getting out of the penalty box");
        }
        $this->player->moveForwardBy($roll);
        echoln($this->player->name
            . "'s new location is "
            . $this->player->currentPlace());
        echoln("The category is " . $this->deck->currentCategory($this->player->currentPlace()));
        echoln($this->deck->askQuestion());

    }


    function wasCorrectlyAnswered(): void
    {
        if ($this->player->isInPenaltyBox() && !$this->isGettingOutOfPenaltyBox) {
            $this->endTurn();
            return;
        }
        if ($this->player->isInPenaltyBox()) {
            echoln("Answer was correct!!!!");
        } else {
            echoln("Answer was corrent!!!!");
        }
        $this->player->addOneCoin();
        echoln($this->player->name
            . " now has "
            . $this->player->coins()
            . " Gold Coins.");

        $this->endTurn();
    }

    function wrongAnswer()
    {
        echoln("Question was incorrectly answered");
        echoln($this->player->name . " was sent to the penalty box");
        $this->player->goToPenaltyBox();
        $this->player->cannotLeavePenaltyBox();
        $this->endTurn();
    }


    function didPlayerWin(Player $player): bool
    {
        return $player->coins() >= 6;
    }

    /**
     * @return void
     */
    public function endTurn(): void
    {
        $this->currentPlayer = ++$this->currentPlayer % $this->howManyPlayers();
        $this->player = $this->players[$this->currentPlayer];
    }
}
