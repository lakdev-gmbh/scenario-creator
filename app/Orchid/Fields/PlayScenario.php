<?php
namespace App\Orchid\Fields;

use Orchid\Screen\Field;

class Playscenario extends Field
{
    /**
     * Blade template
     *
     * @var string
     */
    protected $view = 'playScenario';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'scenario' => null
    ];
}