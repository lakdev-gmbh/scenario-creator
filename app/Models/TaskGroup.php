<?php

namespace App\Models;

use App\Interfaces\Editable;
use App\Traits\Uuids;
use App\Traits\WatermelonId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NathanHeffley\LaravelWatermelon\Traits\Watermelon;
use Orchid\Attachment\Attachable;
use Orchid\Screen\AsSource;

class TaskGroup extends Model implements Editable
{
    use HasFactory;
    use AsSource;
    use Attachable;
    use SoftDeletes, Watermelon;
    use Uuids;
    use WatermelonId;

    protected $primaryKey = 'watermelon_id';

    protected $fillable = [
        'title',
        'weight',
    ];

    protected $watermelonAttributes = [
        'title',
        'weight',
    ];

    public function scenario() {
        return $this->belongsTo(Scenario::class);
    }

    public function taskGroupElements() {
        return $this->tasks->merge($this->infoTexts);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }

    public function infoTexts() {
        return $this->hasMany(InfoText::class);
    }

    public function getEditPath()
    {
        return route('platform.task_group.edit', [
            'scenario' => $this->scenario->getKey(),
            'task_group' => $this->getKey(),
        ]);
    }
}
