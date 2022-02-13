<?php

namespace App\Models;

class Task extends TaskGroupElement
{

    protected $fillable = [
        'title',
        'question',
        'correct_answer',
        'possible_answers',
        'type',
        'weight',
    ];

    protected $watermelonAttributes = [
        'title',
        'question',
        'correct_answer',
        'possible_answers',
        'type',
        'weight',
    ];

    public function getEditPath()
    {
        return route('platform.task.edit', [
            'taskGroup' => $this->taskGroup->getKey(),
            'task' => $this->getKey(),
        ]);
    }
}
