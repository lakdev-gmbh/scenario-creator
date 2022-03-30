<?php

namespace App\Orchid\Screens;

use App\Models\UserGroup;
use App\Orchid\Layouts\UserGroupListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class UserGroupListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'User Groups';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'user_groups' => UserGroup::paginate()
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
            Link::make('Create new')
                ->icon('pencil')
                ->route('platform.user_group.edit')
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
            UserGroupListLayout::class
        ];
    }
}
