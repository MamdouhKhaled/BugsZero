<?php
declare(strict_types=1);

namespace Tests;

use App\QuestionCategory;
use App\QuestionDeck;

beforeEach(function () {
    $this->deck = new QuestionDeck();
});

it('select category depend on player positions', function () {

    expect($this->deck->currentCategory(1))->toBe(QuestionCategory::SCIENCE->value);
});

it('select category and return a askQuestion', function ($category, $question) {
    $this->deck->currentCategory($category);
    expect($question)->toBe($this->deck->askQuestion());
})->with([
    [0, 'Pop Question 0'],
    [1, 'Science Question 0'],
    [2, 'Sports Question 0'],
    [3, 'Rock Question 0']
]);

it('can not answer without category selected', function () {
    $this->deck->askQuestion();
})->throws(\Exception::class);

it('fails when a category deck is exhausted', function () {
    $this->deck->currentCategory(0);
    while (true) {
        $this->deck->askQuestion();
    }
})->throws(\OutOfBoundsException::class);