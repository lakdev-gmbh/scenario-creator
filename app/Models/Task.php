<?php

namespace App\Models;

class Task extends TaskGroupElement
{

    const MULTIPLE_CHOICE = 'multiple_choice';
    const TEXT = 'text';
    const NUMERIC = 'numeric';
    const MULTIPLE_CHOICE_IMAGE = 'multiple_choice_image';
    const HINTED_FILL_IN_THE_BLANK = 'hinted_fill_in_the_blank';
    const ORDER_TEXT = 'order_text';
    const ORDER_IMAGE = 'order_image';

    protected $fillable = [
        'title',
        'question',
        'correct_answer',
        'possible_answers',
        'type',
        'weight',
    ];

    protected $watermelonAttributes = [
        'task_group_watermelon_id',
        'title',
        'question',
        'correct_answer',
        'possible_answers_string',
        'type',
        'weight',
        'options',
    ];

    protected $casts = [
        'possible_answers' => 'array',
        'options' => 'array',
    ];

    public function getEditPath()
    {
        return route('platform.task.edit', [
            'task_group' => $this->taskGroup->getKey(),
            'type' => $this->type,
            'task' => $this->getKey(),
        ]);
    }

    /**
     * @return mixed
     */
    function getPossibleAnswersStringAttribute() {
        return $this->attributes['possible_answers'];
    }

    function getOrderAnswersCorrect() {
        return array_filter($this->possible_answers ?? [], function ($var) {
            return ($var['order'] !== -1);
        });
    }

    function getOrderAnswersExtra() {
        return array_filter($this->possible_answers ?? [], function ($var) {
            return ($var['order'] === -1);
        });
    }

    public function isSingleChoice()
    {
        if($this->type === self::MULTIPLE_CHOICE || $this->type === self::MULTIPLE_CHOICE_IMAGE) {
            $correctAnswers = array_filter($this->possible_answers ?? [], function ($var) {
                return $var['is_correct'] == "1";
            });
            if (count($correctAnswers) === 1) {
                return true;
            }
        }

        return false;
    }
}
