<?php

namespace App\Orchid\Screens;

use App\Models\Property;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PropertyEditScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Property $property): array
    {
        $this->exists = $property->exists;

        if ($this->exists) {
            $this->name = 'Edit property';
        }
        return [
            'property' => $property,
        ];
    }

    public function createOrUpdate(
        Property $property,
        Request  $request
    ) {
        $formData = $request->get('property');
        $property->fill($formData);
        $property->save();

        Alert::info('Property saved.');

        return redirect()->route('platform.property.list');
    }

    /**
     * @param  Property  $property
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Property $property)
    {
        $property->delete();

        Alert::info(__('You have successfully deleted the property.'));

        return redirect()->route('platform.property.list');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make(__('Create property'))
                ->icon('check')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make(__('Update'))
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Are you sure you want to delete this property?'))
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
            Input::make('property.name')
                ->title('Name')
                ->required()
                ->placeholder('name of property')
                ->help('Specify a short descriptive title for this property.'),
            Select::make('property.type')
                ->options([
                    'subject' => 'Subject',
                    'school_year' => 'School year',
                    'topic' => 'Topic',
                ])
                ->title('Type')
                ->required()
                ->placeholder('type of property')
                ->help('Specify the type of the property.'),
        ];

        return [
            Layout::rows($layout),
        ];
    }
}
