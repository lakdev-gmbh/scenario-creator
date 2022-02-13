<?php

namespace App\Orchid\Screens;

use App\Models\Scenario;
use App\Models\TaskGroup;
use App\Models\TaskGroupElement;
use App\Orchid\Fields\Order;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
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
        $taskGroup->fill($request->get('task_group'));
        $taskGroup->scenario_watermelon_id = $scenario->getKey();
        if (!$this->exists) {
            $taskGroup->weight = $taskGroup->scenario->taskGroups()
                    ->count() - 1;
        }
        $taskGroup->save();

        Alert::info('You have successfully created a task group.');

        return redirect()->route('platform.scenario.edit', [
            'scenario' => $scenario->getKey(),
        ]);
    }

    public function updateTaskGroupElementOrder(Scenario $scenario, TaskGroup $taskGroup, Request $request)
    {
        $taskGroupElements = $request->json('taskGroupElements');
        foreach ($taskGroupElements as $taskGroupElement) {
            TaskGroupElement::where('watermelon_id', $taskGroupElement['id'])->update(['weight' => $taskGroupElement['index']]);
        }
        return json_encode([
            'message' => __('Order saved!')
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
            Button::make('Create task group')
                ->icon('check')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Remove')
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
                ->placeholder('Attractive but mysterious title')
                ->help('Specify a short descriptive title for this scenario.'),


        ];
        if ($this->exists) {
            $layout[] =
                Order::make('taskGroupElements')
                    ->title('Task Group Elements')
                    ->method('updateTaskGroupElementOrder')
                    ->editables($this->taskGroup->taskGroupElements()->sortBy('weight'));
        }
        // TODO: add add button for tasks and info texts. here and for task groups in the scenario edit screen
        return [
            Layout::rows($layout),
        ];
    }

}
