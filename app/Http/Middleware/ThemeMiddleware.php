<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ThemeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $theme = 'light'; // тема по умолчанию

        if (Auth::check()) {
            $theme = Auth::user()->theme;
        } else {
            // Можно добавить сохранение темы в сессии для гостей
            $theme = session('theme', 'light');
        }

        // Передаём тему во все представления
        view()->share('currentTheme', $theme);

        // Добавляем тему в данные ответа
        $request->attributes->set('theme', $theme);

        return $next($request);
    }
}
