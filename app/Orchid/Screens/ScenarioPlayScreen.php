<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use App\Models\App;
use App\Models\Scenario;
use Illuminate\Http\Request;
use App\Orchid\Fields\Order;
use App\Orchid\Fields\PlayScenario;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Alert;

class ScenarioPlayScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Play Scenario';

    /**
     * @var bool
     */
    public $exists = false;

    /**
     * @var Scenario
     */
    public $scenario = null;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Scenario $scenario): array
    {
        $this->exists = $scenario->exists;

        if ($this->exists) {
            $this->scenario = $scenario;
        }

        return [
            'scenario' => $scenario,
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        $layout = [
            PlayScenario::make('taskGroups')
                ->title('Play Scenario')
                ->scenario($this->scenario),
        ];

        return [
            //Layout::view('admin.handbook', $this->scenario)
            Layout::rows($layout),
        ];
    }
}