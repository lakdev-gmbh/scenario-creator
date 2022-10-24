<?php

namespace App\Orchid\Screens;

use App\Models\Property;
use App\Orchid\Layouts\PropertyListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class PropertyListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Properties';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'properties' => Property::paginate()
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Add')
                ->icon('plus')
                ->route('platform.property.edit')
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            PropertyListLayout::class
        ];
    }
}
