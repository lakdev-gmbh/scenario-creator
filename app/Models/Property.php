<?php

namespace App\Models;

use App\Traits\BeautifulTimestamps;
use App\Traits\Uuids;
use App\Traits\WatermelonId;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NathanHeffley\LaravelWatermelon\Traits\Watermelon;
use Orchid\Attachment\Attachable;
use Orchid\Screen\AsSource;

class Property extends Model
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
        'type',
    ];

    protected $watermelonAttributes = [
        'name',
        'type'
    ];

    public function scenarios() {
        return $this->belongsToMany(Scenario::class,  'scenarios_properties' , 'property_watermelon_id', 'scenario_watermelon_id');
    }


    /**
     * @param  Builder  $query
     * @param $type
     * @return Builder
     */
    public function scopeType(Builder $query, $type)
    {
        return $query->where('type', $type);
    }
}
