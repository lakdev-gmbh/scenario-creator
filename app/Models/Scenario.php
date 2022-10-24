<?php

namespace App\Models;

use App\Interfaces\Editable;
use App\Traits\BeautifulTimestamps;
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
    use BeautifulTimestamps;

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

    public function userGroups() {
        return $this->belongsToMany(UserGroup::class, 'scenarios_user_groups', 'scenario_watermelon_id','user_group_watermelon_id');
    }

    public function subjects() {
        return $this->belongsToMany(Subject::class, 'scenarios_subjects', 'scenario_watermelon_id','subject_watermelon_id');
    }

    public function replaceUserGroups(?array $userGroups=[]) {
        $this->userGroups()->detach();
        $this->userGroups()->attach($userGroups);
        return $this;
    }

}
