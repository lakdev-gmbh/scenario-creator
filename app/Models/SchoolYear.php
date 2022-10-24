<?php

namespace App\Models;

use App\Traits\BeautifulTimestamps;
use App\Traits\Uuids;
use App\Traits\WatermelonId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NathanHeffley\LaravelWatermelon\Traits\Watermelon;
use Orchid\Attachment\Attachable;
use Orchid\Screen\AsSource;

class SchoolYear extends Model
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
        'name',
    ];

    protected $watermelonAttributes = [
        'name'
    ];

    public function scenarios() {
        return $this->belongsToMany(Scenario::class,  'scenarios_school_years' , 'school_year_watermelon_id', 'scenario_watermelon_id');
    }
}
