<?php

namespace App\Orchid\Layouts;

use App\Models\Scenario;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ScenarioListLayout extends Table
{

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'scenarios';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('title', 'Title')
                ->render(function (Scenario $scenario) {
                    return Link::make($scenario->title)
                        ->route('platform.scenario.edit', $scenario);
                }),
            TD::make('description', 'Description')->width('900px'),
            TD::make('updated_at', 'Last edit'),
            TD::make('edit', 'Edit')
                ->render(function (Scenario $scenario) {
                    return Group::make([
                        Link::make("Edit")
                            ->icon('pencil')
                            ->route('platform.scenario.edit', $scenario),
                        Link::make("Preview")
                            ->icon('eye')
                            ->route('platform.scenario.edit', $scenario),
                    ]);
                }),
        ];
    }

}
