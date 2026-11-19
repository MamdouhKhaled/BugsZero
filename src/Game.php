<?php

namespace App;

use App\Enums\OutputEvent;

class Game
{
    private array $players = [];

    private int $currentPlayer = 0;
    private Player $player;

    function __construct(
        Player               $playerOne,
        Player               $playerTwo,
        private QuestionDeck $deck,
        private Output       $output
    )
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

        $this->output->message(OutputEvent::ADDED_PLAYER, $player->name);
        $this->output->message(OutputEvent::PLAYER_NUMBER, $this->howManyPlayers());

        return true;
    }

    function howManyPlayers()
    {
        return count($this->players);
    }

    function roll($roll)
    {
        $this->output->message(OutputEvent::CURRENT_PLAYER, $this->player->name);
        $this->output->message(OutputEvent::ROLLED, $roll);

        if ($this->player->isInPenaltyBox() && $roll % 2 == 0) {
            $this->output->message(
                OutputEvent::CANNOT_GET_OUT_PENALTY_BOX,
                $this->player->name
            );

            $this->player->cannotLeavePenaltyBox();
            return;
        }

        if ($this->player->isInPenaltyBox()) {
            $this->player->markAsEligibleToLeavePenaltyBox();

            $this->output->message(
                OutputEvent::LEAVE_PENALTY_BOX,
                $this->player->name
            );
        }

        $this->player->moveForwardBy($roll);

        $this->output->message(
            OutputEvent::CHANGED_LOCATION,
            $this->player->name,
            $this->player->currentPlace()
        );

        $this->output->message(
            OutputEvent::CATEGORY,
            $this->deck->currentCategory($this->player->currentPlace())
        );

        $this->output->message(
            OutputEvent::QUESTION,
            $this->deck->askQuestion()
        );
    }

    function wasCorrectlyAnswered(): void
    {
        if ($this->player->isInPenaltyBox() && !$this->player->isEligibleToLeavePenaltyBox()) {
            $this->endTurn();
            return;
        }
        if ($this->player->isEligibleToLeavePenaltyBox()) {
            $this->player->gettingOutFromPenaltyBox();
        }
        if ($this->player->isInPenaltyBox()) {
            $this->output->message(OutputEvent::CORRECT_ANSWER);
        } else {
            $this->output->message(OutputEvent::CORRECT_ANSWER_WITH_TYPE_ERROR);
        }

        $this->player->addOneCoin();

        $this->output->message(
            OutputEvent::GOLD,
            $this->player->name,
            $this->player->coins()
        );

        $this->endTurn();
    }

    function wrongAnswer()
    {
        $this->output->message(OutputEvent::WRONG_ANSWER);

        $this->output->message(
            OutputEvent::GO_TO_PENALTY_BOX,
            $this->player->name
        );

        $this->player->goToPenaltyBox();
        $this->player->cannotLeavePenaltyBox();

        $this->endTurn();
    }

    function didPlayerWin(Player $player): bool
    {
        return $player->coins() >= 6;
    }

    public function endTurn(): void
    {
        $this->player = $this->players[++$this->currentPlayer % $this->howManyPlayers()];
    }
}