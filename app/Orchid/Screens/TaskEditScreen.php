<?php

namespace App\Orchid\Screens;

use App\Models\Scenario;
use App\Models\Task;
use App\Models\TaskGroup;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class TaskEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Creating a new Task';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Task';

    /**
     * @var bool
     */
    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(TaskGroup $taskGroup, Task $task): array
    {
        $this->exists = $task->exists;

        if ($this->exists) {
            $this->name = 'Edit task';
        }
        return [
            'task' => $task
        ];
    }

    public function createOrUpdate(TaskGroup $taskGroup, Task $task, Request $request)
    {
        $task->fill($request->get('task'));
        $task->task_group_watermelon_id = $taskGroup->getKey();
        if (!$this->exists) {
            $task->weight = $task->taskGroup->tasks()->count() - 1;
        }
        $task->save();

        Alert::info('You have successfully created a task.');

        return redirect()->route('platform.task_group.edit', [
            'scenario' => $taskGroup->scenario->getKey(),
            'task_group' => $taskGroup->getKey(),
        ]);
    }


    /**
     *
     * @param  TaskGroup  $taskGroup
     * @param  \App\Models\Task  $task
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(TaskGroup $taskGroup, Task $task)
    {
        $task->delete();

        Alert::info('You have successfully deleted the task.');

        return redirect()->route('platform.task_group.edit', [
            'scenario' => $taskGroup->scenario->getKey(),
            'task_group' => $taskGroup->getKey(),
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
            Button::make('Create task')
                ->icon('check')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Remove')
                ->icon('trash')
                ->confirm(__('Are you sure you want to delete this task?'))
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
            Input::make('task.title')
                ->title('Title')
                ->help(__('Specify an administrative title for this task')),

            Input::make('task.question')
                ->title('Question')
                ->help(__('Specify a question for this task')),

            // TODO: with multiple choice: select index maybe?
            Input::make('task.correct_answer')
                ->title(__('Correct answer'))
                ->help(__('Specify the correct answer to the question')),

            Select::make('task.type')
                ->options([
                    'multiple_choice' => __('Multiple choice'),
                    'text' => __('Text answer'),
                    'numeric' => __('Numeric answer'),
                ])
        ];
        return [
            Layout::rows($layout)
        ];
    }
}
