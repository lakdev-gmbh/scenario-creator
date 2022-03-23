<?php

namespace App\Models;

use App\Interfaces\Editable;
use App\Traits\Uuids;
use App\Traits\WatermelonId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use NathanHeffley\LaravelWatermelon\Traits\Watermelon;
use Orchid\Attachment\Attachable;
use Orchid\Screen\AsSource;

class Scenario extends Model implements Editable
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
        'description',
        'image',
        'user_id',
    ];

    protected $watermelonAttributes = [
        'title',
        'description',
        'image'
    ];

    public function taskGroups() {
        return $this->hasMany(TaskGroup::class);
    }

    public function getEditPath()
    {
        return route('platform.scenario.edit', [
            'scenario' => $this->getKey()
        ]);
    }

    public function getCreatedAtAttribute($value){
        $date = Carbon::parse($value);
        return $date->format('Y-m-d H:i');
    }
    public function getUpdatedAtAttribute($value){
        $date = Carbon::parse($value);
        return $date->format('Y-m-d H:i');
    }
}
