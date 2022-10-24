<?php

namespace App\Orchid\Screens;

use App\Models\Subject;
use App\Orchid\Layouts\SubjectListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class SubjectListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Subjects';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'subjects' => Subject::paginate()
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Add')
                ->icon('plus')
                ->route('platform.subject.edit')
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            SubjectListLayout::class
        ];
    }
}
