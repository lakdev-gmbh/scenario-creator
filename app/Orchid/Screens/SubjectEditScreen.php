<?php

namespace App\Orchid\Screens;

use App\Models\Subject;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class SubjectEditScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Subject $subject): array
    {
        $this->exists = $subject->exists;

        if ($this->exists) {
            $this->name = 'Edit subject';
        }
        return [
            'subject' => $subject,
        ];
    }

    public function createOrUpdate(
        Subject $subject,
        Request $request
    ) {
        $formData = $request->get('subject');
        $subject->fill($formData);
        $subject->save();

        Alert::info('Subject saved.');

        return redirect()->route('platform.subject.list');
    }

    /**
     * @param  Subject  $subject
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Subject $subject)
    {
        $subject->delete();

        Alert::info(__('You have successfully deleted the subject.'));

        return redirect()->route('platform.subject.list');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make(__('Create subject'))
                ->icon('check')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make(__('Update'))
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Are you sure you want to delete this subject?'))
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
            Input::make('subject.name')
                ->title('Name')
                ->required()
                ->placeholder('name of subject')
                ->help('Specify a short descriptive title for this subject.'),
        ];

        return [
            Layout::rows($layout),
        ];
    }
}
