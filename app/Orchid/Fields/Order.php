<?php
namespace App\Orchid\Fields;

use Orchid\Screen\Field;

class Order extends Field
{
    /**
     * Blade template
     *
     * @var string
     */
    protected $view = 'order';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'editables' => null,
        'listClass' => 'sortable-list',
        'method' => null
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [];
}