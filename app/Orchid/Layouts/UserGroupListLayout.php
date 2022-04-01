<?php

namespace App\Orchid\Layouts;

use App\Models\UserGroup;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class UserGroupListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'user_groups';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('title', __('Title'))
                ->render(function (UserGroup $userGroup) {
                    return Link::make($userGroup->title)
                        ->route('platform.user_group.edit', $userGroup);
                }),
            TD::make('updated_at', __('Last edit')),
        ];
    }
}
