<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale {
    public function handle(Request $request, Closure $next) {
        $locale = session('locale', auth()->user()?->preferred_lang ?? config('app.locale', 'ar'));
        if (in_array($locale, ['ar','en'])) {
            app()->setLocale($locale);
        }
        return $next($request);
    }
}
