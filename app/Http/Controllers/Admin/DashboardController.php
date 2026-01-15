<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

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

        $data = $this->normalizeOldPrices($data, $request);
        $data = $this->normalizeOffValues($data, $request);

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

        $data = $this->normalizeOldPrices($data, $request);
        $data = $this->normalizeOffValues($data, $request);

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

            'price_monthly'    => ['nullable', 'numeric', 'min:0'],
            'price_bimestral'  => ['nullable', 'numeric', 'min:0'],
            'price_trimestral' => ['nullable', 'numeric', 'min:0'],
            'price_semestral'  => ['nullable', 'numeric', 'min:0'],
            'price_anual'      => ['nullable', 'numeric', 'min:0'],

            'old_price_monthly'    => ['nullable', 'numeric', 'min:0'],
            'old_price_bimestral'  => ['nullable', 'numeric', 'min:0'],
            'old_price_trimestral' => ['nullable', 'numeric', 'min:0'],
            'old_price_semestral'  => ['nullable', 'numeric', 'min:0'],
            'old_price_anual'      => ['nullable', 'numeric', 'min:0'],
            'price_monthly_old'    => ['nullable', 'numeric', 'min:0'],
            'price_bimestral_old'  => ['nullable', 'numeric', 'min:0'],
            'price_trimestral_old' => ['nullable', 'numeric', 'min:0'],
            'price_semestral_old'  => ['nullable', 'numeric', 'min:0'],
            'price_anual_old'      => ['nullable', 'numeric', 'min:0'],

            'off_monthly'    => ['nullable', 'integer', 'min:0', 'max:100'],
            'off_bimestral'  => ['nullable', 'integer', 'min:0', 'max:100'],
            'off_trimestral' => ['nullable', 'integer', 'min:0', 'max:100'],
            'off_semestral'  => ['nullable', 'integer', 'min:0', 'max:100'],
            'off_anual'      => ['nullable', 'integer', 'min:0', 'max:100'],

            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable'],
        ]);
    }

    private function normalizeOffValues(array $data, Request $request): array
    {
        $pairs = [
            'monthly'    => ['off' => 'off_monthly',    'legacy' => 'off_mensual'],
            'bimestral'  => ['off' => 'off_bimestral',  'legacy' => 'off_bimestral'],
            'trimestral' => ['off' => 'off_trimestral', 'legacy' => 'off_trimestral'],
            'semestral'  => ['off' => 'off_semestral',  'legacy' => 'off_semestral'],
            'anual'      => ['off' => 'off_anual',      'legacy' => 'off_anual'],
        ];

        foreach ($pairs as $p) {
            $hasOffColumn = Schema::hasColumn('tools', $p['off']);
            $hasLegacyColumn = Schema::hasColumn('tools', $p['legacy']);

            if (!$hasOffColumn) {
                unset($data[$p['off']]);
            }

            if ($hasLegacyColumn && array_key_exists($p['off'], $data)) {
                $data[$p['legacy']] = $data[$p['off']];
            }

            if (!$hasOffColumn && $hasLegacyColumn && $request->filled($p['off'])) {
                $data[$p['legacy']] = $request->input($p['off']);
            }
        }

        return $data;
    }

    private function normalizeOldPrices(array $data, Request $request): array
    {
        $map = [
            'monthly' => ['old' => 'old_price_monthly', 'legacy' => 'price_monthly_old'],
            'bimestral' => ['old' => 'old_price_bimestral', 'legacy' => 'price_bimestral_old'],
            'trimestral' => ['old' => 'old_price_trimestral', 'legacy' => 'price_trimestral_old'],
            'semestral' => ['old' => 'old_price_semestral', 'legacy' => 'price_semestral_old'],
            'anual' => ['old' => 'old_price_anual', 'legacy' => 'price_anual_old'],
        ];

        foreach ($map as $fields) {
            $hasOldColumn = Schema::hasColumn('tools', $fields['old']);
            $hasLegacyColumn = Schema::hasColumn('tools', $fields['legacy']);

            if (!$hasOldColumn && $hasLegacyColumn) {
                if (array_key_exists($fields['old'], $data)) {
                    $data[$fields['legacy']] = $data[$fields['old']];
                } elseif ($request->filled($fields['legacy'])) {
                    $data[$fields['legacy']] = $request->input($fields['legacy']);
                }
            }

            if ($hasOldColumn && !array_key_exists($fields['old'], $data) && $request->filled($fields['legacy'])) {
                $data[$fields['old']] = $request->input($fields['legacy']);
            }

            if ($hasLegacyColumn && array_key_exists($fields['old'], $data)) {
                $data[$fields['legacy']] = $data[$fields['old']];
            }

            if (!$hasOldColumn) {
                unset($data[$fields['old']]);
            }
        }

        return $data;
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
