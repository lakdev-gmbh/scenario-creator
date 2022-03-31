<?php

namespace App\Orchid\Screens;

use App\Models\InfoText;
use App\Models\Scenario;
use App\Models\Task;
use App\Models\TaskGroup;
use App\Models\TaskGroupElement;
use App\Orchid\Fields\Order;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class TaskGroupEditScreen extends Screen
{

    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Creating a new Task Group';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Task Group';

    /**
     * @var string
     */
    public $permission = 'platform.scenario.edit';

    /**
     * @var bool
     */
    public $exists = false;

    public $taskGroup = null;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Scenario $scenario, TaskGroup $taskGroup): array
    {
        $this->exists = $taskGroup->exists;

        if ($this->exists) {
            $this->name = 'Edit task group';
            $this->taskGroup = $taskGroup;
        }
        return [
            'task_group' => $taskGroup,
        ];
    }

    public function createOrUpdate(
        Scenario $scenario,
        TaskGroup $taskGroup,
        Request $request
    ) {
        $this->exists = $taskGroup->exists;
        $taskGroup->fill($request->get('task_group'));
        $taskGroup->scenario_watermelon_id = $scenario->getKey();
        if (!$this->exists) {
            $taskGroup->weight = $taskGroup->scenario->taskGroups()
                    ->count() - 1;
        }
        $taskGroup->save();

        Alert::info('Task Group saved.');

        if ($this->exists) {
            return redirect()->route('platform.scenario.edit', [
                'scenario' => $scenario->getKey(),
            ]);
        } else {
            return redirect()->route('platform.task_group.edit', [
                'scenario' => $scenario->getKey(),
                'task_group' => $taskGroup->getKey(),
            ]);
        }
    }

    public function updateTaskGroupElementOrder(
        Scenario $scenario,
        TaskGroup $taskGroup,
        Request $request
    ) {
        $taskGroupElements = $request->json('taskGroupElements');
        foreach ($taskGroupElements as $taskGroupElement) {
            if ($taskGroupElement['class'] === InfoText::class) {
                InfoText::where('watermelon_id', $taskGroupElement['id'])
                    ->update(['weight' => $taskGroupElement['index']]);
            } elseif ($taskGroupElement['class'] === Task::class) {
                Task::where('watermelon_id', $taskGroupElement['id'])
                    ->update(['weight' => $taskGroupElement['index']]);
            }
        }
        return json_encode([
            'message' => __('Order saved!'),
        ]);
    }

    /**
     * @param  TaskGroup  $taskGroup
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Scenario $scenario, TaskGroup $taskGroup)
    {
        $taskGroup->delete();

        Alert::info('You have successfully deleted the task group.');

        return redirect()->route('platform.scenario.edit', [
            'scenario' => $taskGroup->scenario->getKey(),
        ]);
    }


    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make(__('Create task group'))
                ->icon('check')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make(__('Update and return to scenario'))
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Are you sure you want to delete this task group?'))
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
            Input::make('task_group.title')
                ->title('Title')
                ->required()
                ->placeholder('Attractive but mysterious title')
                ->help('Specify a short descriptive title for this task group.'),
        ];
        if ($this->exists) {
            $layout[] =
                Order::make('taskGroupElements')
                    ->title('Task Group Elements')
                    ->method('updateTaskGroupElementOrder')
                    ->editables($this->taskGroup->taskGroupElements()
                        ->sortBy('weight'));
            $layout[] =
                Link::make('Add Info Text')
                    ->route('platform.info_text.edit', [
                        'task_group' => $this->taskGroup->id(),
                    ]);
            $layout[] =
                Link::make('Add multiple choice Task')
                    ->route('platform.task.edit', [
                        'type' => Task::MULTIPLE_CHOICE,
                        'task_group' => $this->taskGroup->id(),
                    ]);
            $layout[] =
                Link::make('Add text Task')
                    ->route('platform.task.edit', [
                        'type' => Task::TEXT,
                        'task_group' => $this->taskGroup->id(),
                    ]);
            $layout[] =
                Link::make('Add multiple choice image Task')
                    ->route('platform.task.edit', [
                        'type' => Task::MULTIPLE_CHOICE_IMAGE,
                        'task_group' => $this->taskGroup->id(),
                    ]);
            $layout[] =
                Link::make('Add numeric Task')
                    ->route('platform.task.edit', [
                        'type' => Task::NUMERIC,
                        'task_group' => $this->taskGroup->id(),
                    ]);

        }
        return [
            Layout::rows($layout),
        ];
    }

}
