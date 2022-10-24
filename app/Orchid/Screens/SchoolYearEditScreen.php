<?php

namespace App\Orchid\Screens;

use App\Models\SchoolYear;
use App\Models\Subject;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class SchoolYearEditScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(SchoolYear $school_year): array
    {
        $this->exists = $school_year->exists;

        if ($this->exists) {
            $this->name = 'Edit school year';
        }
        return [
            'school_year' => $school_year,
        ];
    }

    public function createOrUpdate(
        SchoolYear $school_year,
        Request $request
    ) {
        $formData = $request->get('school_year');
        $school_year->fill($formData);
        $school_year->save();

        Alert::info('School year saved.');

        return redirect()->route('platform.school_year.list');
    }

    /**
     * @param  Subject  $school_year
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(SchoolYear $school_year)
    {
        $school_year->delete();

        Alert::info(__('You have successfully deleted the school year.'));

        return redirect()->route('platform.school_year.list');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make(__('Create school year'))
                ->icon('check')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make(__('Update'))
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Are you sure you want to delete this school year?'))
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
            Input::make('school_year.name')
                ->title('Name')
                ->required()
                ->placeholder('name of school year')
                ->help('Specify a short descriptive title for this school year.'),
        ];

        return [
            Layout::rows($layout),
        ];
    }
}
