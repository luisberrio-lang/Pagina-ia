<?php

namespace App\Http\Controllers;

use App\Models\Tool;

class PageController extends Controller
{
    public function inicio()
    {
        return view('pages.inicio');
    }

    public function herramientas()
    {
        $tools = Tool::where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('pages.herramientas', compact('tools'));
    }

    public function precio()
    {
        $tools = Tool::where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('pages.precio', compact('tools'));
    }

    public function soporte()
    {
        return view('pages.soporte');
    }

    public function faq()
    {
        return view('pages.faq');
    }
}
