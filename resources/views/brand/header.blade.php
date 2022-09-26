@push('head')
    <meta name="robots" content="noindex" />
    <link
            href="/favicon.ico"
            id="favicon"
            rel="icon"
    >
    <style>
        .dropdown-menu li {
            padding: 0 0 0 10px;
        }
    </style>
@endpush

<div class="h2 fw-light d-flex align-items-center">
    <p class="ms-3 my-0 d-none d-sm-block">
        {{ __('Scenario Creator') }}
    </p>
</div>
<style>
    .dropdown-toggle::after {
        display: inline-block;
        margin-left: 0.255em;
        vertical-align: 0.255em;
        content: "";
        border-top: 0.3em solid;
        border-right: 0.3em solid transparent;
        border-bottom: 0;
        border-left: 0.3em solid transparent;
    }
</style>
<div style="display: inline-block;
margin-left: 15px;
margin-right: 10px;" class="dropdown">
    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="fi fi-{{ \App\Http\Middleware\LocaleChecker::getLocaleFlag() }}"></span> {{ strtoupper(\App\Http\Middleware\LocaleChecker::getCurrentLocale()) }}
    </a>

    <ul class="dropdown-menu" style="min-width: 0; width: max-content" aria-labelledby="dropdownMenuLink">
        @foreach(\App\Http\Middleware\LocaleChecker::getAvailableLocales() as $key => $value)
            <li>
                <span class="fi fi-{{ \App\Http\Middleware\LocaleChecker::getLocaleFlag($key) }}"></span><a style="color: black; " href="{{ route('locale.setting', $key) }}">{{ $value }}</a>
            </li>
        @endforeach
    </ul>
</div>

