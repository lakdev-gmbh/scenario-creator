<?php

namespace App\Models;

class InfoText extends TaskGroupElement
{
    protected $primaryKey = 'watermelon_id';

    protected $fillable = [
        'title',
        'body',
        'weight',
    ];

    protected $watermelonAttributes = [
        'title',
        'body',
        'weight',
    ];

    public function getEditPath()
    {
        return route('platform.info_text.edit', [
            'task_group' => $this->taskGroup->getKey(),
            'info_text' => $this->getKey(),
        ]);
    }

}
