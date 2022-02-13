<?php

namespace App\Models;

class InfoText extends TaskGroupElement
{
    protected $primaryKey = 'watermelon_id';

    protected $fillable = [
        'body',
        'weight',
    ];

    protected $watermelonAttributes = [
        'body',
        'weight',
    ];

    public function getEditPath()
    {
        return route('platform.info_text.edit', [
            'taskGroup' => $this->taskGroup->getKey(),
            'info_text' => $this->getKey(),
        ]);
    }

}
