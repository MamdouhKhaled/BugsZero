<?php

namespace App;

class QuestionDeck
{
    private array $popQuestions = [];
    private array $scienceQuestions = [];
    private array $sportsQuestions = [];
    private array $rockQuestions = [];

    private QuestionCategory $currentQuestionCategory;
    public function __construct()
    {
        for ($i = 0; $i < 50; $i++) {
            array_push($this->popQuestions, "Pop Question " . $i);
            array_push($this->scienceQuestions, ("Science Question " . $i));
            array_push($this->sportsQuestions, ("Sports Question " . $i));
            array_push($this->rockQuestions, ("Rock Question " . $i));
        }
    }

    function askQuestion(): string
    {
        $category = sprintf('%sQuestions', strtolower($this->currentQuestionCategory->value));
        return array_shift($this->{$category});
    }

    function currentCategory(int $place):string
    {
        $this->currentQuestionCategory = match ($place) {
            0, 4, 8 => QuestionCategory::POP,
            1, 5, 9 => QuestionCategory::SCIENCE,
            2, 6, 10 => QuestionCategory::SPORTS,
            default => QuestionCategory::ROCK,
        };
        return $this->currentQuestionCategory->value;
    }
}