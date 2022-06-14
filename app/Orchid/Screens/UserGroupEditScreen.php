<?php

namespace App\Orchid\Screens;

use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class UserGroupEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Creating a new User Group';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'User Group';

    /**
     * @var bool
     */
    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(UserGroup $userGroup): array
    {
        $this->exists = $userGroup->exists;

        if ($this->exists) {
            $this->name = 'Edit user group';
        }
        return [
            'user_group' => $userGroup,
        ];
    }

    public function createOrUpdate(
        UserGroup $userGroup,
        Request $request
    ) {
        $formData = $request->get('user_group');
        $userGroup->fill($formData);
        $author_id = Auth::id();
        $userGroup->user_watermelon_id = $author_id;
        $userGroup->save();
        if ($userGroup->exists) {
            $userGroup->replaceUsers($request->input('user_group.users'));
        } else {
            // On create add author automatically.
            $userGroup->replaceUsers([$author_id]);
        }

        Alert::info('User Group saved.');

        return redirect()->route('platform.user_group.edit', [
            'user_group' => $userGroup->getKey(),
        ]);
    }

    /**
     * @param  UserGroup  $userGroup
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(UserGroup $userGroup)
    {
        $userGroup->delete();

        Alert::info('You have successfully deleted the task group.');

        return redirect()->route('platform.user_group.list');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make(__('Create user group'))
                ->icon('check')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make(__('Update'))
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Are you sure you want to delete this user group?'))
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
            Input::make('user_group.title')
                ->title('Title')
                ->required()
                ->placeholder('Attractive but mysterious title')
                ->help('Specify a short descriptive title for this user group.'),
        ];
        if ($this->exists) {
            $layout[] =
                Relation::make('user_group.users.')
                    ->fromModel(User::class, 'name')
                    ->multiple()
                    ->title('Choose users');
        }
        return [
            Layout::rows($layout),
        ];
    }
}
