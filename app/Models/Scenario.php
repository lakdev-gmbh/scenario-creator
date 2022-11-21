<?php

namespace App\Models;

use App\Interfaces\Editable;
use App\Traits\BeautifulTimestamps;
use App\Traits\Uuids;
use App\Traits\WatermelonId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
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

    public function properties() {
        return $this
            ->belongsToMany(Property::class, 'scenarios_properties', 'scenario_watermelon_id','property_watermelon_id')
            ->wherePivot('deleted_at', null)
            ->withPivot('watermelon_id')
            ->withTimestamps();
    }

    public function subjects() {
        return $this->properties()->type('subject');
    }

    public function topics() {
        return $this->properties()->type('topic');
    }

    public function school_years() {
        return $this->properties()->type('school_year');
    }

    public function replaceUserGroups(?array $userGroups=[]) {
        $this->userGroups()->detach();
        $this->userGroups()->attach($userGroups);
        return $this;
    }

    public function replaceProperties(?array $properties=[]) {
        $oldPropertyIds = $this->properties()->pluck('property_watermelon_id');

        foreach ($properties as $property) {
            if (!in_array($property, $oldPropertyIds->toArray())) {
                $newScenarioProperty = new ScenariosProperty([
                    'scenario_watermelon_id' => $this->getKey(),
                    'property_watermelon_id' => $property
                ]);
                $newScenarioProperty->save();
            }
        }

        // Mark rows that are not
        DB::table('scenarios_properties')
            ->where('scenario_watermelon_id', $this->getKey())
            ->whereNotIn('property_watermelon_id', $properties)
            ->update(['deleted_at' => Date::now()]);
        return $this;
    }

}
