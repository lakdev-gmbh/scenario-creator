<?php

namespace App\Orchid\Screens;

use App\Models\Scenario;
use App\Orchid\Layouts\ScenarioListLayout;
use Illuminate\Support\Facades\Auth;
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
     * @var string
     */
    public $permission = 'platform.scenario.access_all';

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
            Link::make('Add')
                ->icon('plus')
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
