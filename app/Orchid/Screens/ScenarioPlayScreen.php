<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use App\Models\App;
use App\Models\Scenario;
use Illuminate\Http\Request;
use App\Orchid\Fields\PlayScenario;
use Orchid\Screen\Actions\Link;

class ScenarioPlayScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Play scenario';

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
            $this->scenario = Scenario::with('taskGroups.tasks', 'taskGroups.infoTexts')
                                ->get()
                                ->where("watermelon_id", "=", $scenario->watermelon_id);
        }

        return [
            'scenario' => $this->scenario,
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
        return [
            Layout::view('playScenario', ['scenario' => $this->scenario])
        ];
    }
}