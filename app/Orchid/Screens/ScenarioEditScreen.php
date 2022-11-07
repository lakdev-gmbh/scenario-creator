<?php

namespace App\Orchid\Screens;

use App\Models\App;
use App\Models\Property;
use App\Models\Scenario;
use App\Models\TaskGroup;
use App\Models\UserGroup;
use App\Orchid\Fields\Order;
use App\Orchid\Fields\Select;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
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
        if (!$scenario->exists) {
            $scenario->user_watermelon_id = Auth::user()->id();
        }
        $scenario->save();

        $scenario->replaceUserGroups($request->input('scenario.user_groups'));

        $subjects = $request->input('scenario.subjects', []);
        $schoolYears = $request->input('scenario.school_years', []);
        $topics = $request->input('scenario.topics', []);
        foreach ($topics as $key => $topic) {
            if (Property::whereWatermelonId($topic)->doesntExist()) {
                $topic = new Property([
                    'name' => $topic,
                    'type' => 'topic',
                ]);
                $topic->save();
                $topics[$key] = $topic->id();
            }
        }
        $scenario->replaceProperties(array_merge($subjects, $schoolYears, $topics));

        Alert::info(__('Scenario saved.'));

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

            Link::make('Play')
                ->icon('control-play')
                ->route('platform.scenario.play', $this->scenario)
                ->canSee($this->exists),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     * @throws BindingResolutionException
     */
    public function layout(): array
    {
        $layout = [
            Input::make('scenario.title')
                ->title('Title')
                ->placeholder('Attractive but mysterious title')
                ->required()
                ->help('Specify a short descriptive title for this scenario.'),

            Cropper::make('scenario.image')
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
                Relation::make('scenario.subjects.')
                    ->fromModel(Property::class, 'name', 'watermelon_id')
                    ->applyScope('type', 'subject')
                    ->multiple()
                    ->title('Subjects that this scenario covers');
            $layout[] =
                Relation::make('scenario.school_years.')
                    ->applyScope('type', 'school_year')
                    ->fromModel(Property::class, 'name', 'watermelon_id')
                    ->multiple()
                    ->title('School years that this scenario covers');
            $layout[] =
                Select::make('scenario.topics.')
                    ->fromQuery(Property::query()->type('topic'), 'name', 'watermelon_id')
                    ->multiple()
                    ->allowAdd()
                    ->title('Topics that this scenario covers');
            $layout[] =
                Relation::make('scenario.user_groups.')
                    ->fromModel(UserGroup::class, 'title', 'watermelon_id')
                    ->multiple()
                    ->value($this->scenario->userGroups)
                    ->title('User groups to share this scenario with');
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
