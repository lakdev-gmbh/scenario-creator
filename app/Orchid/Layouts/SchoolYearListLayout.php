<?php

namespace App\Orchid\Layouts;

use App\Models\SchoolYear;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SchoolYearListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'school_years';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', __('Name'))
                ->render(function (SchoolYear $school_year) {
                    return Link::make($school_year->name)
                        ->route('platform.school_year.edit', $school_year);
                }),
            TD::make('updated_at', __('Last edit')),
        ];
    }
}
