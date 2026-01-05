<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tools = Tool::orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('admin.dashboard', compact('tools'));
    }

    public function storeTool(Request $request)
    {
        $data = $request->validate([
            'tag'        => ['nullable', 'string', 'max:50'],
            'title'      => ['required', 'string', 'max:120'],
            'subtitle'   => ['required', 'string', 'max:255'],
            'price'      => ['nullable', 'string', 'max:60'],
            'details'    => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active'  => ['nullable'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Tool::create($data);

        return back()->with('status', '✅ Herramienta creada');
    }

    public function destroyTool(Tool $tool)
    {
        $tool->delete();
        return back()->with('status', '🗑️ Herramienta eliminada');
    }
}
