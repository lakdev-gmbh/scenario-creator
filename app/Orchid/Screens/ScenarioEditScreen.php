<?php

namespace App\Orchid\Screens;

use App\Models\App;
use App\Models\Scenario;
use App\Models\TaskGroup;
use App\Orchid\Fields\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ScenarioEditScreen extends Screen
{

    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Creating a new Scenario';


    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Scenario';

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
            $this->name = 'Edit scenario';
            $this->scenario = $scenario;
        }

        return [
            'scenario' => $scenario,
        ];
    }

    public function createOrUpdate(Scenario $scenario, Request $request)
    {
        $scenario->fill($request->get('scenario'));
        $scenario->user_id = Auth::id();
        $scenario->save();

        Alert::info('Scenario saved.');

        return redirect()->route('platform.scenario.edit', [
            'scenario' => $scenario->getKey(),
        ]);
    }

    public function updateTaskGroupOrder(Scenario $scenario, Request $request)
    {
        $taskGroups = $request->json('taskGroups');
        foreach ($taskGroups as $taskGroup) {
            TaskGroup::where('watermelon_id', $taskGroup['id'])->update(['weight' => $taskGroup['index']]);
        }
        return json_encode([
            'message' => __('Order saved!')
        ]);
    }

    /**
     * @param  Scenario  $scenario
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Scenario $scenario)
    {
        $scenario->delete();

        Alert::info('You have successfully deleted the scenario.');

        return redirect()->route('platform.scenario.list');
    }


    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create scenario')
                ->icon('check')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Remove')
                ->icon('trash')
                ->confirm(__('Are you sure you want to delete this scenario?'))
                ->method('remove')
                ->canSee($this->exists),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        $layout = [
            Input::make('scenario.title')
                ->title('Title')
                ->placeholder('Attractive but mysterious title')
                ->required()
                ->help('Specify a short descriptive title for this scenario.'),

            Picture::make('scenario.image')
                ->title('Scenario image')
                ->targetRelativeUrl(),

            TextArea::make('scenario.description')
                ->title('Description')
                ->required()
                ->rows(3)
                ->placeholder('Brief description'),
        ];
        if ($this->exists) {
            $layout[] =
                Order::make('taskGroups')
                    ->title('Task Groups')
                    ->method('updateTaskGroupOrder')
                    ->editables($this->scenario->taskGroups->sortBy('weight'));
            $layout[] =
                Link::make('Add Task Group')
                    ->route('platform.task_group.edit', [
                        'scenario' => $this->scenario->id(),
                    ]);
        }


        return [
            Layout::rows($layout),
        ];
    }

}
