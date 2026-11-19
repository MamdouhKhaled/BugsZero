<?php

namespace App;

class Player
{
    private int $place = 0;
    private int $coins = 0;
    private bool $inPenalty = false;

    private bool $canLeavePenaltyBox = false;
    public function __construct(
        public readonly string $name,
    )
    {
    }

    public function currentPlace(): int
    {
        return $this->place;
    }

    public function moveForwardBy(int $place): void
    {
        if ($place <= 0) {
            throw new \Exception('Invalid position');
        }
        if ($place >= 6) {
            throw new \Exception('can\'t move forward more 6 at once');
        }
        $this->place = ($this->place + $place)%12;
    }

    public function coins(): int
    {
        return $this->coins;
    }

    public function addOneCoin(): void
    {
        $this->coins++;
    }

    public function isInPenaltyBox(): bool
    {
        return $this->inPenalty;
    }

    public function gettingOutFromPenaltyBox(): void
    {
        $this->inPenalty = false;
        $this->canLeavePenaltyBox = false;
    }

    public function goToPenaltyBox(): void
    {
        $this->inPenalty = true;
        $this->canLeavePenaltyBox = false;
    }

    public function isEligibleToLeavePenaltyBox(): bool
    {
        return $this->inPenalty && $this->canLeavePenaltyBox;
    }

    public function markAsEligibleToLeavePenaltyBox(): void
    {
        if (!$this->inPenalty) {
            throw new \LogicException('Player is not in the penalty box');
        }
        $this->canLeavePenaltyBox = true;
    }

    public function cannotLeavePenaltyBox(): void
    {
        $this->canLeavePenaltyBox = false;
    }
}