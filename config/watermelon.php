<?php

use App\Models\InfoText;
use App\Models\Scenario;
use App\Models\ScenariosProperty;
use App\Models\Task;
use App\Models\TaskGroup;
use App\Models\Property;

return [

    'route' => env('WATERMELON_ROUTE', '/sync'),

    'middleware' => [],

    'models' => [
        'info_texts' => InfoText::class,
        'scenarios' => Scenario::class,
        'task_groups' => TaskGroup::class,
        'tasks' => Task::class,
        'property' => Property::class,
        'scenarios_properties' => ScenariosProperty::class
    ],

];
