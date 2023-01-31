<?php

declare(strict_types=1);

use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\HandbookScreen;
use App\Orchid\Screens\InfoTextEditScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\ScenarioEditScreen;
use App\Orchid\Screens\ScenarioListOwnScreen;
use App\Orchid\Screens\ScenarioListScreen;
use App\Orchid\Screens\ScenarioListSharedScreen;
use App\Orchid\Screens\ScenarioPlayScreen;
use App\Orchid\Screens\PropertyEditScreen;
use App\Orchid\Screens\PropertyListScreen;
use App\Orchid\Screens\TaskEditScreen;
use App\Orchid\Screens\TaskGroupEditScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Screens\UserGroupEditScreen;
use App\Orchid\Screens\UserGroupListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('User'), route('platform.systems.users.edit', $user));
    });

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{roles}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });

Route::screen('scenario/{scenario?}', ScenarioEditScreen::class)
    ->name('platform.scenario.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.scenario.list')
            ->push(__('Create'), route('platform.scenario.edit'));
    });

Route::screen('scenarios', ScenarioListScreen::class)
    ->name('platform.scenario.list')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Scenario'), route('platform.scenario.list'));
    });

Route::screen('my-scenarios', ScenarioListOwnScreen::class)
    ->name('platform.scenario.list_own')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('My Scenarios'), route('platform.scenario.list_own'));
    });

Route::screen('shared-scenarios', ScenarioListSharedScreen::class)
    ->name('platform.scenario.list_shared')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Shared Scenarios'), route('platform.scenario.list_shared'));
    });

Route::screen('playscenario/{scenario?}', ScenarioPlayScreen::class)
    ->name('platform.scenario.play')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.scenario.list')
            ->push(__('Play'), route('platform.scenario.play'));
    });

Route::screen('task_group/{scenario}/{task_group?}', TaskGroupEditScreen::class)
    ->name('platform.task_group.edit');

Route::screen('info_text/{task_group}/{type}/{info_text?}', InfoTextEditScreen::class)
    ->name('platform.info_text.edit');

Route::screen('task/{task_group}/{type}/{task?}', TaskEditScreen::class)
    ->name('platform.task.edit');

Route::screen('handbook', HandbookScreen::class)
    ->name('platform.handbook');

Route::screen('user_group/{user_group?}', UserGroupEditScreen::class)
    ->name('platform.user_group.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.user_group.list')
            ->push(__('Create'), route('platform.user_group.edit'));
    });

Route::screen('user_groups', UserGroupListScreen::class)
    ->name('platform.user_group.list')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('User Group'), route('platform.user_group.list'));
    });

Route::screen('property/{property?}', PropertyEditScreen::class)
    ->name('platform.property.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.property.list')
            ->push(__('Create'), route('platform.property.edit'));
    });

Route::screen('properties', PropertyListScreen::class)
    ->name('platform.property.list')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Properties'), route('platform.property.list'));
    });

