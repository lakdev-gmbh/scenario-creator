<?php

namespace App\Orchid\Screens;

use App\Models\Scenario;
use App\Models\Task;
use App\Models\TaskGroup;
use App\Orchid\Fields\RadioImage;
use App\Rules\NumericAnswer;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Radio;
use Orchid\Screen\Fields\RadioButtons;
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
     * @var string
     */
    public $permission = 'platform.scenario.edit';

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
        Request $request,
        ?Task $task = null
    ) {
        if (is_null($task)) {
            $task = new Task();
        }
        // Validate numeric answers
        if ($type === Task::NUMERIC) {
            $request->validate([
                'task.correct_answer' => ['required', new NumericAnswer]
            ]);
        }

        $task->fill($request->get('task'));
        $task->type = $type;
        $task->task_group_watermelon_id = $taskGroup->getKey();
        if (!$task->exists) {
            $task->weight = $task->taskGroup->taskGroupElements()->count() - 1;
        }

        if ($type === Task::MULTIPLE_CHOICE && $task->isSingleChoice()) {
            $task->options = ['design' => $request->get('design')];
        } else {
            $task->options = null;
        }

        if ($type === Task::ORDER_TEXT || $type === Task::ORDER_IMAGE){
            $task->options = ['left_to_right' => (bool) $request->get('left_to_right')];
            $extraAnswers = [];
            foreach ($request->get('order_answers_extra') as $extraAnswer) {
                $extraAnswers[] = ['answer' => $extraAnswer['answer'], 'order' => -1];
            }
            $task->possible_answers = [... $request->get('order_answers_correct'), ...$extraAnswers ];
        }

        $task->save();

        Alert::info(__('Task saved.'));

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
                            __('Answer') => 'answer',
                            __('Correct?') => 'is_correct',
                        ])
                        ->fields([
                            'answer'   => TextArea::make('answer'),
                            'is_correct' => CheckBox::make('is_correct')->sendTrueOrFalse(),
                        ])
                        ->title(__('Possible answers'))
                        ->required();
                // TODO: add in design
//                if ($this->task->exists && $this->task->isSingleChoice()) {
//                    $layout[] = RadioImage::make('design')
//                        ->title(__('Design'))
//                        ->options([
//                            // TODO: update with new images
//                            'standard' => '/img/mc-var1.png',
//                            'stacked' => '/img/mc-var1.png',
//                            'wheel' => '/img/mc-var2.png',
//                        ])
//                        ->value($this->task->options['design'] ?? null);
//                }
                break;
            case Task::ORDER_TEXT:
            case Task::ORDER_IMAGE:
                if ($this->task->type === Task::ORDER_TEXT) {
                    $answerField = TextArea::make('answer');
                } elseif ($this->task->type === Task::ORDER_IMAGE) {
                    $answerField = Cropper::make('answer');
                }


                $layout[] = CheckBox::make('left_to_right')
                    ->title(__('Left to right'))
                    ->sendTrueOrFalse()
                    ->value($this->task->options['left_to_right'] ?? false)
                    ->help(__('If checked, the answers will be displayed from left to right. Otherwise, from top to bottom.'));

                $layout[] =
                    Matrix::make('order_answers_correct')
                        ->columns([
                            __('Answer') => 'answer',
                            __('Order (1 to n)') => 'order',
                        ])
                        ->fields([
                            'answer'   => $answerField,
                            'order' => Input::make('order')
                                ->type('number')
                                ->min(1)
                                ->required()
                                ->placeholder(1),
                        ])
                        ->title(__('Correct order'))
                        ->value($this->task->getOrderAnswersCorrect())
                        ->required();
                $layout[] =
                    Matrix::make('order_answers_extra')
                        ->columns([
                            __('Answer') => 'answer',
                        ])
                        ->fields([
                            'answer'   => $answerField,
                        ])
                        ->value($this->task->getOrderAnswersExtra())
                        ->title(__('Extra answers'))
                        ->required();
                break;
            case Task::MULTIPLE_CHOICE_IMAGE:
                $layout[] =
                    Matrix::make('task.possible_answers')
                        ->columns([
                            __('Answer') => 'answer',
                            __('Correct?') => 'is_correct',
                        ])
                        ->fields([
                            'answer'   => Cropper::make('answer'),
                            'is_correct' => CheckBox::make('is_correct')->sendTrueOrFalse(),
                        ])
                        ->title(__('Possible answers'))
                        ->required();
                break;
            case Task::NUMERIC:
                $layout[] = Input::make('task.correct_answer')
                    ->title(__('Correct numeric answer'))
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
