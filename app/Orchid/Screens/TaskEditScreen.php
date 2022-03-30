<?php

namespace App\Orchid\Screens;

use App\Models\Scenario;
use App\Models\Task;
use App\Models\TaskGroup;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
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
     * @var \App\Models\Task
     */
    private $task;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(TaskGroup $taskGroup, $type, Task $task): array
    {
        $task->type = $type;
        $this->exists = $task->exists;
        $this->task = $task;
        if ($this->exists) {
            $this->name = 'Edit task';
            $this->task = $task;
        }
        return [
            'task' => $task,
        ];
    }

    public function createOrUpdate(
        TaskGroup $taskGroup,
        $type,
        Task $task,
        Request $request
    ) {
        $task->fill($request->get('task'));
        $task->type = $type;
        $task->task_group_watermelon_id = $taskGroup->getKey();
        if (!$this->exists) {
            $task->weight = $task->taskGroup->taskGroupElements()->count() - 1;
        }
        $task->save();

        Alert::info('Task saved.');

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
    public function remove(TaskGroup $taskGroup, $type, Task $task)
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
                ->required()
                ->help(__('Specify an administrative title for this task')),

            Input::make('task.question')
                ->title('Question')
                ->required()
                ->help(__('Specify a question for this task')),
        ];
        switch ($this->task->type) {
            case Task::MULTIPLE_CHOICE:
                $layout[] =
                    Matrix::make('task.possible_answers')
                        ->columns([
                            'Answer' => 'answer',
                            'Correct?' => 'is_correct',
                        ])
                        ->fields([
                            'answer'   => TextArea::make('answer'),
                            'is_correct' => CheckBox::make('is_correct')->sendTrueOrFalse(),
                        ])
                        ->title(__('Possible answers'))
                        ->required()
                        ->help(__('Specify the possible answers to the question'));
                break;
            case Task::MULTIPLE_CHOICE_IMAGE:
                $layout[] =
                    Matrix::make('task.possible_answers')
                        ->columns([
                            'Answer' => 'answer',
                            'Correct?' => 'is_correct',
                        ])
                        ->fields([
                            'answer'   => Picture::make('answer'),
                            'is_correct' => CheckBox::make('is_correct')->sendTrueOrFalse(),
                        ])
                        ->title(__('Possible answers'))
                        ->required()
                        ->help(__('Specify the possible answers to the question'));
                break;
            case Task::NUMERIC:
                $layout[] = Input::make('task.correct_answer')
                    ->title(__('Correct answer'))
                    ->type('number')
                    ->required()
                    ->help(__('Specify the correct answer to the question'));
                break;
            case Task::TEXT:
                $layout[] = Input::make('task.correct_answer')
                    ->title(__('Correct answer'))
                    ->required()
                    ->help(__('Specify the correct answer to the question'));
                break;
        }


        return [Layout::rows($layout),];

    }

}