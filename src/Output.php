<?php

namespace App;

use App\Enums\OutputEvent;
use App\Interfaces\OutputAdaptorInterface;

class Output
{
    private array $messages = [
        OutputEvent::ADDED_PLAYER->value => "%s was added",
        OutputEvent::PLAYER_NUMBER->value => "They are player number %d",
        OutputEvent::CURRENT_PLAYER->value => "%s is the current player",
        OutputEvent::ROLLED->value => "They have rolled a %d",
        OutputEvent::CHANGED_LOCATION->value => '%s\'s new location is %d',
        OutputEvent::CATEGORY->value => 'The category is %s',
        OutputEvent::QUESTION->value => '%s',
        OutputEvent::CORRECT_ANSWER->value => 'Answer was correct!!!!',
        OutputEvent::CORRECT_ANSWER_WITH_TYPE_ERROR->value => 'Answer was corrent!!!!',
        OutputEvent::WRONG_ANSWER->value => 'Question was incorrectly answered',
        OutputEvent::GOLD->value => '%s now has %d Gold Coins.',
        OutputEvent::CANNOT_GET_OUT_PENALTY_BOX->value => '%s is not getting out of the penalty box',
        OutputEvent::GO_TO_PENALTY_BOX->value => '%s was sent to the penalty box',
        OutputEvent::LEAVE_PENALTY_BOX->value => '%s is getting out of the penalty box'
    ];

    public function __construct(private OutputAdaptorInterface $adaptor)
    {
    }

    public function message(OutputEvent $event, ...$arg): void
    {
        $message = $this->messages[$event->value];

        $this->adaptor->write(sprintf($message, ...$arg));
    }
}