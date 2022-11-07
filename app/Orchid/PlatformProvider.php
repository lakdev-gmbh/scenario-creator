<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [

            Menu::make('Scenarios')
                ->title('Content')
                ->icon('docs')
                ->permission('platform.scenario.access_all')
                ->route('platform.scenario.list'),

            Menu::make('My Scenarios')
                ->icon('docs')
                ->route('platform.scenario.list_own')
                ->permission('platform.scenario.access_own'),

            Menu::make('Shared Scenarios')
                ->icon('docs')
                ->route('platform.scenario.list_shared')
                ->permission('platform.scenario.access_shared'),

            Menu::make('User Groups')
                ->icon('user-follow')
                ->route('platform.user_group.list'),

            Menu::make('Properties')
                ->icon('book-open')
                ->route('platform.property.list'),

            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),

            ItemPermission::group(__('Scenario'))
                ->addPermission('platform.scenario.edit', __('Create/Edit scenarios'))
                ->addPermission('platform.scenario.access_all', __('Access all scenarios'))
                ->addPermission('platform.scenario.access_own', __('Access own scenarios'))
                ->addPermission('platform.scenario.access_shared', __('Access shared scenarios'))
                ->addPermission('platform.scenario.play', __('Play scenarios'))
        ];
    }
}
