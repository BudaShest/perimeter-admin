<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ThemeController extends Controller
{
    public function toggle(Request $request)
    {
        $newTheme = null;
        $message = '';

        if (Auth::check()) {
            $user = Auth::user();
            $newTheme = $user->toggleTheme();
            $message = 'Тема изменена на ' . ($newTheme === 'dark' ? 'тёмную' : 'светлую');
        } else {
            $currentTheme = $request->cookie('theme', 'light');
            $newTheme = $currentTheme === 'light' ? 'dark' : 'light';
            $message = 'Тема изменена на ' . ($newTheme === 'dark' ? 'тёмную' : 'светлую');
        }

        return response()
            ->json([
                'success' => true,
                'theme' => $newTheme,
                'message' => $message
            ])
            ->cookie('theme', $newTheme, 60 * 24 * 30); // 30 дней
    }

    public function setTheme(Request $request, $theme)
    {
        if (!in_array($theme, ['light', 'dark'])) {
            return response()->json([
                'success' => false,
                'message' => 'Неверная тема'
            ], 400);
        }

        $message = '';

        if (Auth::check()) {
            $user = Auth::user();
            $user->theme = $theme;
            $user->save();
            $message = 'Тема установлена на ' . ($theme === 'dark' ? 'тёмную' : 'светлую');
        } else {
            $message = 'Тема установлена на ' . ($theme === 'dark' ? 'тёмную' : 'светлую');
        }

        return response()
            ->json([
                'success' => true,
                'theme' => $theme,
                'message' => $message
            ])
            ->cookie('theme', $theme, 60 * 24 * 30); // 30 дней
    }

    public function getTheme(Request $request)
    {
        $theme = 'light';

        if (Auth::check()) {
            $theme = Auth::user()->theme;
        } else {
            $theme = $request->cookie('theme', 'light');
        }

        return response()->json([
            'success' => true,
            'theme' => $theme
        ]);
    }
}
