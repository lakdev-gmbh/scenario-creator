<?php

namespace App\Orchid\Layouts;

use App\Models\Subject;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SubjectListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'subjects';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', __('Name'))
                ->render(function (Subject $subject) {
                    return Link::make($subject->name)
                        ->route('platform.subject.edit', $subject);
                }),
            TD::make('updated_at', __('Last edit')),
        ];
    }
}
