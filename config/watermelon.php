<?php

use App\Models\InfoText;
use App\Models\Scenario;
use App\Models\Task;
use App\Models\TaskGroup;

return [

    'route' => env('WATERMELON_ROUTE', '/sync'),

    'middleware' => [],

    'models' => [
        'info_texts' => InfoText::class,
        'scenarios' => Scenario::class,
        'task_groups' => TaskGroup::class,
        'tasks' => Task::class,
    ],

];
