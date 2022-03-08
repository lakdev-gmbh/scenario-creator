<div class="bg-white rounded-top shadow-sm mb-3">

    <div class="row g-0">
        <div class="col col-lg-6 mt-6 p-4 pe-md-0">

            <h2 class="mt-2 text-dark fw-light">
                {{ __('Welcome to our scenario creator!') }}
            </h2>

{{--            <p>--}}
{{--                {{ __('') }}--}}
{{--            </p>--}}
        </div>
        <div class="col col-lg-6 mt-6 p-4 pe-md-0">
            <img style="max-height: 100px;" class="img-fluid" src="/img/co-financed-EU-de.png"  alt="{{ __('Co-financed by the European Union') }}"/>
        </div>
    </div>

    <div class="row bg-light m-0 p-4 border-top rounded-bottom">

        <div class="col-md-6 my-2">
            <h3 class="text-muted fw-light">
                <x-orchid-icon path="book-open"/>

                <span class="ms-3 text-dark"><a class="text-u-l" href="{{ route('platform.handbook') }}">{{ __('Explore the handbook') }}</a></span>
            </h3>
            <p class="ms-md-5 ps-md-1">
                {{ __('The handbook contains all information you need to create educational, exciting and unique scenarios') }}The package uses the Laravel framework.

            </p>
        </div>

        <div class="col-md-6 my-2">
            <h3 class="text-muted fw-light">
                <x-orchid-icon path="monitor"/>

                <span class="ms-3 text-dark"><a class="text-u-l" href="{{ route('platform.scenario.edit') }}">{{ __('Create a scenario') }}</a></span>
            </h3>
            <p class="ms-md-5 ps-md-1">
                {{ __('Use the scenario creator to create a unique experience for your students and millions of students around the world.') }}
            </p>
        </div>
    </div>

</div>

