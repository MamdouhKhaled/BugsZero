<?php

use App\QuestionCategory;
use App\QuestionDeck;

it('select category depend on player positions', function () {
    $QuestionDeck = new QuestionDeck();
    expect($QuestionDeck->currentCategory(1))->toBe(QuestionCategory::SCIENCE->value);
});

it('select category and return a askQuestion', function ($category, $question) {
    $QuestionDeck = new QuestionDeck();
    $QuestionDeck->currentCategory($category);
    expect($question)->toBe($QuestionDeck->askQuestion());
})->with([
    [0, 'Pop Question 0'],
    [1, 'Science Question 0'],
    [2, 'Sports Question 0'],
    [3, 'Rock Question 0']
]);