<?php

namespace App\Models;

class InfoText extends TaskGroupElement
{
    const INFO_TEXT = 'info_text';
    const SPEECH_BUBBLE = 'speech_bubble';

    protected $primaryKey = 'watermelon_id';

    protected $fillable = [
        'title',
        'body',
        'weight',
    ];

    protected $watermelonAttributes = [
        'task_group_watermelon_id',
        'title',
        'body',
        'weight',
        'type',
    ];

    public function getEditPath()
    {
        return route('platform.info_text.edit', [
            'task_group' => $this->taskGroup->getKey(),
            'type' => $this->type ?? self::INFO_TEXT,
            'info_text' => $this->getKey(),
        ]);
    }

}
