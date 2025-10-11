<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThemeController extends Controller
{
    public function toggle(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $theme = $user->toggleTheme();

            return response()->json([
                'success' => true,
                'theme' => $theme,
                'message' => 'Тема изменена на ' . ($theme === 'dark' ? 'тёмную' : 'светлую')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Пользователь не авторизован'
        ], 401);
    }

    public function setTheme(Request $request, $theme)
    {
        if (!in_array($theme, ['light', 'dark'])) {
            return response()->json([
                'success' => false,
                'message' => 'Неверная тема'
            ], 400);
        }

        if (Auth::check()) {
            $user = Auth::user();
            $user->theme = $theme;
            $user->save();

            return response()->json([
                'success' => true,
                'theme' => $theme,
                'message' => 'Тема установлена на ' . ($theme === 'dark' ? 'тёмную' : 'светлую')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Пользователь не авторизован'
        ], 401);
    }
}
