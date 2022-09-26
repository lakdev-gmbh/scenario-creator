<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleChecker
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
            App::setLocale(config('app.locale'));
        }
        return $next($request);
    }

    public static function getLocaleFlag($locale = NULL): string
    {
        if (!isset($locale)) {
            $locale = self::getCurrentLocale();
        }
        return match ($locale) {
            'en' => 'gb',
            'zh' => 'cn',
            default => $locale,
        };
    }

    public static function getAvailableLocales()
    {
        return [
            'en' => __('English') . ' (EN)',
            'de' => __('German') . ' (DE)',
            /*
            'it' => __('Italian') . ' (IT)',
            'pl' => __('Polish') . ' (PL)',
            'zh' => __('Chinese') . ' (ZH)',
            'es' => __('Spanish') . ' (ES)',
            'tr' => __('Turkish') . ' (TR)',
            'ru' => __('Russian') . ' (RU)',
            */
        ];
    }


    public static function getCurrentLocale() {
        return Session::get('locale') ?? App::getLocale();
    }

    public static function getCurrentLocaleString()
    {
        $locale = self::getCurrentLocale();
        return self::getAvailableLocales()[$locale];
    }
}
