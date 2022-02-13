<?php

namespace App\Orchid\Screens;

use App\Models\Scenario;
use App\Orchid\Layouts\ScenarioListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class ScenarioListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Scenarios';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'scenarios' => Scenario::paginate()
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
            Link::make('Create new')
                ->icon('pencil')
                ->route('platform.scenario.edit')
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
            ScenarioListLayout::class
        ];
    }
}
