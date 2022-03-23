<?php

namespace App\Orchid\Screens;

use App\Models\InfoText;
use App\Models\TaskGroup;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
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
     * @var bool
     */
    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(TaskGroup $taskGroup, InfoText $infoText): array
    {
        $this->exists = $infoText->exists;

        if ($this->exists) {
            $this->name = 'Edit Info Text';
        }
        return [
            'info_text' => $infoText
        ];
    }

    public function createOrUpdate(TaskGroup $taskGroup, InfoText $infoText, Request $request)
    {
        $infoText->fill($request->get('info_text'));
        $infoText->task_group_watermelon_id = $taskGroup->getKey();
        if (!$this->exists) {
            $infoText->weight = $infoText->taskGroup->taskGroupElements()->count() - 1;
        }
        $infoText->save();

        Alert::info('Info Text saved.');

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
    public function remove(TaskGroup $taskGroup, InfoText $infoText)
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
                ->help(__('Specify a title for this info text')),

            Quill::make('info_text.body')
                ->title('Body')
                ->required()
                ->help(__('The info text')),
        ];
        return [
            Layout::rows($layout)
        ];
    }
}
