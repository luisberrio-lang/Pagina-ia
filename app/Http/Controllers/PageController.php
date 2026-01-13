<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;

class PageController extends Controller
{
    public function inicio()
    {
        return view('pages.inicio');
    }

    public function herramientas(Request $request)
    {
        $tools = Tool::where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $activeTool = null;

        if ($request->filled('tool')) {
            $activeTool = $tools->firstWhere('id', (int) $request->tool);
        }

        if (!$activeTool) {
            $activeTool = $tools->first();
        }

        return view('pages.herramientas', compact('tools', 'activeTool'));
    }

    // Para que no te rompa /precio y quede consistente
    public function precio(Request $request)
    {
        // Lo mandamos a Herramientas IA y abrimos la sección planes
        return redirect()->to(
            route('herramientas', $request->filled('tool') ? ['tool' => $request->tool] : []) . '#planes'
        );
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
