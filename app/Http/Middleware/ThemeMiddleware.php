<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ThemeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $theme = 'light'; // тема по умолчанию

        // Для авторизованных пользователей - из базы данных
        if (Auth::check()) {
            $theme = Auth::user()->theme;
        }
        // Для гостей - из куки
        else {
            $theme = $request->cookie('theme', 'light');
        }

        // Принудительно применяем тему к HTML
        View::share('currentTheme', $theme);

        // Сохраняем в запросе для дальнейшего использования
        $request->attributes->set('theme', $theme);

        $response = $next($request);

        // Убеждаемся, что тема установлена в HTML
        if ($response->getContent()) {
            $content = $response->getContent();

            // Добавляем тему в HTML атрибут, если её там нет
            if (strpos($content, 'data-bs-theme') === false) {
                $content = preg_replace(
                    '/<html[^>]*>/',
                    '<html lang="ru" data-bs-theme="' . $theme . '">',
                    $content
                );
            }

            $response->setContent($content);
        }

        return $response;
    }
}
