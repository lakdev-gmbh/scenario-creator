<?php

namespace App\Orchid\Layouts;

use App\Models\Property;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PropertyListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'properties';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', __('Name'))
                ->render(function (Property $property) {
                    return Link::make($property->name)
                        ->route('platform.property.edit', $property);
                }),
            TD::make('updated_at', __('Last edit')),
        ];
    }
}
