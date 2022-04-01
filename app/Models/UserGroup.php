<?php

namespace App\Models;

use App\Traits\BeautifulTimestamps;
use App\Traits\Uuids;
use App\Traits\WatermelonId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NathanHeffley\LaravelWatermelon\Traits\Watermelon;
use Orchid\Screen\AsSource;

class UserGroup extends Model
{
    use SoftDeletes, Watermelon;
    use AsSource;
    use Uuids;
    use WatermelonId;
    use BeautifulTimestamps;


    protected $primaryKey = 'watermelon_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    protected $watermelonAttributes = [
        'title',
    ];

    public function users() {
        return $this->belongsToMany(User::class,  'users_user_groups' , 'user_group_watermelon_id','user_watermelon_id');
    }

    public function scenarios() {
        return $this->belongsToMany(Scenario::class,  'scenarios_user_groups' , 'user_group_watermelon_id', 'scenario_watermelon_id');
    }

    public function author() {
        return $this->belongsTo(User::class);
    }

    public function replaceUsers(?array $users=[]) {
        $this->users()->detach();
        $this->users()->attach($users);
        return $this;
    }

}
