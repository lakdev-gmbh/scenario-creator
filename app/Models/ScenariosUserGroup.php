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

class ScenariosUserGroup extends Model
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
        'scenario_watermelon_id',
        'user_group_watermelon_id',
    ];

    protected $watermelonAttributes = [
        'user_group_watermelon_id',
        'scenario_watermelon_id',
    ];

    protected $table = 'scenarios_user_groups';
}
