<?php

namespace App\Orchid\Screens;

use App\Models\SchoolYear;
use App\Orchid\Layouts\SchoolYearListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class SchoolYearListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'SchoolYear';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'school_years' => SchoolYear::paginate()
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
                ->route('platform.school_year.edit')
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
            SchoolYearListLayout::class
        ];
    }
}
