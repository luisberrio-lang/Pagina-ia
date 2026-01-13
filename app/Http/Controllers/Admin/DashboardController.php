<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tools = Tool::orderBy('sort_order')->orderByDesc('id')->get();
        return view('admin.dashboard', compact('tools'));
    }

    public function storeTool(Request $request)
    {
        $data = $this->validateTool($request);

        $data['is_active']  = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $data['highlights'] = $this->parseLines($request->input('highlights_text'));
        $data['extras']     = $this->parseLines($request->input('extras_text'));
        $data['includes']   = $this->parseIncludeLines($request->input('includes_text'));

        unset($data['highlights_text'], $data['includes_text'], $data['extras_text']);

        Tool::create($data);

        return back()->with('status', '✅ Pack creado');
    }

    public function updateTool(Request $request, Tool $tool)
    {
        $data = $this->validateTool($request);

        $data['is_active']  = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $data['highlights'] = $this->parseLines($request->input('highlights_text'));
        $data['extras']     = $this->parseLines($request->input('extras_text'));
        $data['includes']   = $this->parseIncludeLines($request->input('includes_text'));

        unset($data['highlights_text'], $data['includes_text'], $data['extras_text']);

        $tool->update($data);

        return back()->with('status', '✅ Pack actualizado');
    }

    public function destroyTool(Tool $tool)
    {
        $tool->delete();
        return back()->with('status', '🗑️ Pack eliminado');
    }

    private function validateTool(Request $request): array
    {
        return $request->validate([
            'tag' => ['nullable', 'string', 'max:50'],
            'title' => ['required', 'string', 'max:120'],
            'subtitle' => ['required', 'string', 'max:255'],

            'short_desc' => ['nullable', 'string', 'max:180'],
            'badge_text' => ['nullable', 'string', 'max:50'],

            'highlights_text' => ['nullable', 'string'],
            'includes_text' => ['nullable', 'string'],
            'extras_text' => ['nullable', 'string'],
            'audience' => ['nullable', 'string'],

            'price_monthly' => ['nullable', 'numeric', 'min:0'],
            'price_semestral' => ['nullable', 'numeric', 'min:0'],
            'price_anual' => ['nullable', 'numeric', 'min:0'],
            'savings_semestral' => ['nullable', 'numeric', 'min:0'],
            'savings_anual' => ['nullable', 'numeric', 'min:0'],

            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable'],
        ]);
    }

    private function parseLines(?string $text): array
    {
        $lines = preg_split("/\r\n|\n|\r/", $text ?? '');
        $out = [];
        foreach ($lines as $l) {
            $l = trim($l);
            if ($l !== '') $out[] = $l;
        }
        return $out;
    }

    private function parseIncludeLines(?string $text): array
    {
        $lines = $this->parseLines($text);
        $rows = [];

        foreach ($lines as $line) {
            $sep = str_contains($line, '|') ? '|' : (str_contains($line, ':') ? ':' : null);
            if (!$sep) continue;

            [$label, $value] = explode($sep, $line, 2);
            $label = trim($label);
            $value = trim($value);

            if ($label !== '' && $value !== '') {
                $rows[] = ['label' => $label, 'text' => $value];
            }
        }

        return $rows;
    }
}
