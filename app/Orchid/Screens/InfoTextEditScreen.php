<?php

namespace App\Orchid\Screens;

use App\Models\InfoText;
use App\Models\TaskGroup;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class InfoTextEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Creating a new Info text';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Info text';

    /**
     * @var string
     */
    public $permission = 'platform.scenario.edit';

    /**
     * @var bool
     */
    public $exists = false;

    /**
     * @var InfoText
     */
    public $infoText;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(TaskGroup $taskGroup, $type, InfoText $infoText): array
    {
        $infoText->type = $type;
        $this->infoText = $infoText;
        $this->exists = $infoText->exists;

        if ($this->exists) {
            $this->name = 'Edit Info Text';
        }
        return [
            'info_text' => $infoText
        ];
    }

    public function createOrUpdate(
        TaskGroup $taskGroup,
        $type,
        Request $request,
        ?InfoText $infoText = null )
    {
        if (is_null($infoText)) {
            $infoText = new InfoText();
        }
        $infoText->fill($request->get('info_text'));
        $infoText->type = $type;
        $infoText->task_group_watermelon_id = $taskGroup->getKey();
        if (!$infoText->exists) {
            $infoText->weight = $infoText->taskGroup->taskGroupElements()->count() - 1;
        }
        $infoText->save();

        Alert::info(__('Info Text saved.'));

        return redirect()->route('platform.task_group.edit', [
            'scenario' => $taskGroup->scenario->getKey(),
            'task_group' => $taskGroup->getKey(),
        ]);
    }


    /**
     *
     * @param  TaskGroup  $taskGroup
     * @param  \App\Models\InfoText  $infoText
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(TaskGroup $taskGroup, $type, InfoText $infoText)
    {
        $infoText->delete();

        Alert::info('You have successfully deleted the info text.');

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
            Button::make('Create info text')
                ->icon('check')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Remove')
                ->icon('trash')
                ->confirm(__('Are you sure you want to delete this info text?'))
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
            Input::make('info_text.title')
                ->title('Title')
                ->required()
                ->help(__('Specify a title for this info text.')),
        ];


        switch ($this->infoText->type) {
            case InfoText::INFO_TEXT:
                $layout[] = Quill::make('info_text.body')
                    ->title('Info Text')
                    ->required();
                break;
            case InfoText::SPEECH_BUBBLE:
                $layout[] = TextArea::make('info_text.body')
                    ->title('Speech bubble text')
                    ->rows(6)
                    ->maxlength(420)
                    ->required();
                break;
        }
        return [
            Layout::rows($layout)
        ];
    }
}
