<?php

namespace App\Enums;

enum OutputEvent: string
{
    case ADDED_PLAYER = 'AddedPlayer';
    case PLAYER_NUMBER = 'PlayerNumber';
    case CURRENT_PLAYER = 'CurrentPlayer';
    case ROLLED = 'Rolled';
    case CHANGED_LOCATION = 'ChangedLocation';
    case CATEGORY = 'Category';
    case QUESTION = 'Question';
    case ANSWER = 'Answer';
    case ANSWER_WITH_TYPE_ERROR = 'AnswerWithTypeError';
    case GOLD = 'Gold';
    case CANNOT_GET_OUT_PENALTY_BOX = 'CanNotGetOutPenaltyBox';
    case GO_TO_PENALTY_BOX = 'GoToPenaltyBox';
    case CORRECT_ANSWER = 'CorrectAnswer';
    case CORRECT_ANSWER_WITH_TYPE_ERROR = 'CorrectAnswerWithTypeError';
    case WRONG_ANSWER = 'WrongAnswer';
    case LEAVE_PENALTY_BOX = 'LeavePenaltyBox';
}