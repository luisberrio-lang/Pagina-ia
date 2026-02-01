<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $tools = Tool::orderBy('sort_order')->orderByDesc('id')->get();
        return view('admin.dashboard', compact('tools'));
    }

    public function storeTool(Request $request)
    {
        $rawUpload = $request->files->get('media');
        if ($request->files->has('media') && (!$rawUpload || !$rawUpload->isValid())) {
            $code = $rawUpload ? $rawUpload->getError() : 'desconocido';
            return back()->withErrors(['media' => "No se pudo subir el archivo (código $code)."]);
        }
        if ($request->input('media_selected') && !$request->hasFile('media') && !$request->boolean('media_remove')) {
            return back()->withErrors(['media' => 'No se recibió el archivo. Revisa el tamaño o vuelve a seleccionarlo.']);
        }
        if ($request->boolean('media_active') && !$request->hasFile('media')) {
            return back()->withErrors(['media' => 'Selecciona un archivo para activar el video.']);
        }

        $data = $this->validateTool($request);

        $data['is_active']  = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $data = $this->normalizeOldPrices($data, $request);
        $data = $this->normalizeOffValues($data, $request);

        $data['highlights'] = $this->parseLines($request->input('highlights_text'));
        $data['extras']     = $this->parseLines($request->input('extras_text'));
        $data['includes']   = $this->parseIncludeLines($request->input('includes_text'));

        $hasFile = $request->hasFile('media');
        $mediaData = $this->processToolMedia($request, null);
        if (isset($mediaData['__media_error'])) {
            return back()->withErrors(['media' => $mediaData['__media_error']]);
        }
        if ($hasFile && empty($mediaData['media_path'])) {
            return back()->withErrors(['media' => 'No se pudo guardar el archivo. Intenta nuevamente.']);
        }

        if ($request->hasFile('media')) {
            $request->session()->flash('debug_media_store', [
                'context' => 'store',
                'tool_id' => null,
                'hasFile' => $request->hasFile('media'),
                'media_path' => $mediaData['media_path'] ?? null,
                'exists' => isset($mediaData['media_path'])
                    ? Storage::disk('public')->exists($mediaData['media_path'])
                    : false,
            ]);
        }

        unset(
            $data['highlights_text'],
            $data['includes_text'],
            $data['extras_text'],
            $data['media'],
            $data['media_active'],
            $data['media_remove']
        );

        Tool::create(array_merge($data, $mediaData));

        return back()->with('status', '✅ Pack creado');
    }

    public function updateTool(Request $request, Tool $tool)
    {
        $rawUpload = $request->files->get('media');
        if ($request->files->has('media') && (!$rawUpload || !$rawUpload->isValid())) {
            $code = $rawUpload ? $rawUpload->getError() : 'desconocido';
            return back()->withErrors(['media' => "No se pudo subir el archivo (código $code)."]);
        }
        if ($request->input('media_selected') && !$request->hasFile('media') && !$request->boolean('media_remove')) {
            return back()->withErrors(['media' => 'No se recibió el archivo. Revisa el tamaño o vuelve a seleccionarlo.']);
        }
        if ($request->has('media') || $request->hasFile('media') || $request->boolean('media_active')) {
            $file = $request->file('media');
            $request->session()->flash('debug_media', [
                'hasFile' => $request->hasFile('media'),
                'filePresent' => $file ? 'yes' : 'no',
                'name' => $file ? $file->getClientOriginalName() : null,
                'size' => $file ? $file->getSize() : null,
                'error' => $file ? $file->getError() : null,
                'active' => $request->boolean('media_active'),
            ]);
        }

        if ($request->boolean('media_active') && !$request->hasFile('media') && !$tool->media_path) {
            return back()->withErrors(['media' => 'Selecciona un archivo para activar el video.']);
        }

        $data = $this->validateTool($request);

        $data['is_active']  = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $data = $this->normalizeOldPrices($data, $request);
        $data = $this->normalizeOffValues($data, $request);

        $data['highlights'] = $this->parseLines($request->input('highlights_text'));
        $data['extras']     = $this->parseLines($request->input('extras_text'));
        $data['includes']   = $this->parseIncludeLines($request->input('includes_text'));

        $hasFile = $request->hasFile('media');
        $mediaData = $this->processToolMedia($request, $tool);
        \Log::info('tool_media_process_result', [
            'tool_id' => $tool->id,
            'media_data' => $mediaData,
        ]);
        if (isset($mediaData['__media_error'])) {
            return back()->withErrors(['media' => $mediaData['__media_error']]);
        }
        if ($hasFile && empty($mediaData['media_path'])) {
            return back()->withErrors(['media' => 'No se pudo guardar el archivo. Intenta nuevamente.']);
        }

        if ($request->hasFile('media')) {
            $request->session()->flash('debug_media_store', [
                'context' => 'update',
                'tool_id' => $tool->id,
                'hasFile' => $request->hasFile('media'),
                'media_path' => $mediaData['media_path'] ?? null,
                'exists' => isset($mediaData['media_path'])
                    ? Storage::disk('public')->exists($mediaData['media_path'])
                    : false,
            ]);
        }

        unset(
            $data['highlights_text'],
            $data['includes_text'],
            $data['extras_text'],
            $data['media'],
            $data['media_active'],
            $data['media_remove']
        );

        $tool->update(array_merge($data, $mediaData));

        return back()->with('status', '✅ Pack actualizado');
    }

    public function updateToolMedia(Request $request, Tool $tool)
    {
        \Log::info('tool_media_request', [
            'tool_id' => $tool->id,
            'has_media_selected' => (bool) $request->input('media_selected'),
            'has_file' => $request->hasFile('media'),
            'has_remove' => $request->boolean('media_remove'),
            'has_toggle' => $request->boolean('media_toggle'),
            'file_name' => $request->file('media')?->getClientOriginalName(),
            'file_size' => $request->file('media')?->getSize(),
            'file_mime' => $request->file('media')?->getClientMimeType(),
        ]);
        $rawUpload = $request->files->get('media');
        if ($request->files->has('media') && (!$rawUpload || !$rawUpload->isValid())) {
            $code = $rawUpload ? $rawUpload->getError() : 'desconocido';
            return back()->withErrors(['media' => "No se pudo subir el archivo (código $code)."]);
        }

        $hasFile = $request->hasFile('media');
        $hasRemove = $request->boolean('media_remove');
        $hasToggle = $request->boolean('media_toggle');

        if ($request->input('media_selected') && !$request->hasFile('media') && !$request->boolean('media_remove')) {
            return back()->withErrors(['media' => 'No se recibió el archivo. Revisa el tamaño o vuelve a seleccionarlo.']);
        }

        if ($request->boolean('media_active') && !$request->hasFile('media') && !$tool->media_path) {
            return back()->withErrors(['media' => 'Selecciona un archivo para activar el video.']);
        }

        if (!$hasFile && !$hasRemove && !$hasToggle) {
            return back()->withErrors(['media' => 'No se detectó ningún cambio. Selecciona un archivo o marca eliminar.']);
        }

        $data = $request->validate([
            'media' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,image/gif', 'max:8192'],
            'media_active' => ['nullable', 'boolean'],
            'media_remove' => ['nullable', 'boolean'],
            'media_selected' => ['nullable'],
            'media_toggle' => ['nullable', 'boolean'],
        ]);

        $mediaData = $this->processToolMedia($request, $tool);
        if (isset($mediaData['__media_error'])) {
            return back()->withErrors(['media' => $mediaData['__media_error']]);
        }

        if (($hasFile || $hasRemove || $hasToggle) && !empty($mediaData)) {
            $tool->update($mediaData);
            \Log::info('tool_media_updated', [
                'tool_id' => $tool->id,
                'saved_path' => $tool->media_path,
                'saved_active' => $tool->media_active,
            ]);
        }

        return back()
            ->with('status', '✅ Video del pack actualizado')
            ->with('status_media_tool_id', $tool->id);
    }

    public function deleteToolMedia(Tool $tool)
    {
        if ($tool->media_path && Storage::disk('public')->exists($tool->media_path)) {
            Storage::disk('public')->delete($tool->media_path);
        }

        $tool->update([
            'media_path' => null,
            'media_mime' => null,
            'media_original_name' => null,
            'media_size_bytes' => null,
            'media_active' => false,
        ]);

        return back()
            ->with('status', '✅ Video eliminado')
            ->with('status_media_tool_id', $tool->id);
    }

    public function destroyTool(Tool $tool)
    {
        if ($tool->media_path && Storage::disk('public')->exists($tool->media_path)) {
            Storage::disk('public')->delete($tool->media_path);
        }
        $tool->delete();
        return back()->with('status', '🗑️ Pack eliminado');
    }

    public function updateTopMedia(Request $request)
    {
        $data = $request->validate([
            'media' => [
                'nullable',
                'file',
                'mimetypes:video/mp4,video/webm,image/gif',
                'max:8192',
            ],
            'active' => ['nullable', 'boolean'],
        ]);

        // Auto-activate when a new file is uploaded to avoid "uploaded but hidden" confusion.
        $active = $request->hasFile('media') ? true : $request->boolean('active');
        $existing = SiteMedia::where('key', 'tools_top_media')->first();

        if (!$request->hasFile('media') && !$existing) {
            return back()->with('status', 'Info: sube un video para activar la tarjeta');
        }

        if ($request->hasFile('media')) {
            $file = $data['media'];
            $ext = strtolower($file->getClientOriginalExtension() ?: 'mp4');
            $name = 'tools-top-' . Str::uuid() . '.' . $ext;

            $path = $file->storeAs('media', $name, 'public');

            if ($existing && $existing->path && Storage::disk('public')->exists($existing->path)) {
                Storage::disk('public')->delete($existing->path);
            }

            SiteMedia::updateOrCreate(
                ['key' => 'tools_top_media'],
                [
                    'path' => $path,
                    'mime' => $file->getClientMimeType(),
                    'original_name' => $file->getClientOriginalName(),
                    'size_bytes' => $file->getSize(),
                    'active' => $active,
                ]
            );
        } elseif ($existing) {
            $existing->update(['active' => $active]);
        }

        return back()->with('status', 'Video actualizado');
    }

    public function deleteTopMedia()
    {
        $existing = SiteMedia::where('key', 'tools_top_media')->first();
        if ($existing) {
            if ($existing->path && Storage::disk('public')->exists($existing->path)) {
                Storage::disk('public')->delete($existing->path);
            }
            $existing->delete();
        }

        return back()->with('status', 'Video eliminado');
    }

    private function processToolMedia(Request $request, ?Tool $tool = null): array
    {
        $out = [];
        $hasFile = $request->hasFile('media');
        $remove = $request->boolean('media_remove');
        // Auto-activate when uploading a new file so it appears on the site immediately.
        $toggleRequested = $request->boolean('media_toggle');
        $active = $hasFile ? true : ($toggleRequested ? $request->boolean('media_active') : ($tool?->media_active ?? false));

        if ($remove && !$hasFile && $tool && $tool->media_path) {
            if (Storage::disk('public')->exists($tool->media_path)) {
                Storage::disk('public')->delete($tool->media_path);
            }
            return [
                'media_path' => null,
                'media_mime' => null,
                'media_original_name' => null,
                'media_size_bytes' => null,
                'media_active' => false,
            ];
        }

        if ($hasFile) {
            $file = $request->file('media');
            if (!$file || !$file->isValid()) {
                return ['__media_error' => 'No se pudo subir el archivo. Intenta nuevamente.'];
            }
            $ext = strtolower($file->getClientOriginalExtension() ?: 'mp4');
            $name = 'tool-media-' . Str::uuid() . '.' . $ext;
            Storage::disk('public')->makeDirectory('media');
            $path = $file->storeAs('media', $name, 'public');
            \Log::info('tool_media_store', [
                'tool_id' => $tool?->id,
                'path' => $path,
                'exists' => $path ? Storage::disk('public')->exists($path) : false,
                'size' => $file->getSize(),
                'mime' => $file->getClientMimeType(),
            ]);
            if (!$path || !Storage::disk('public')->exists($path)) {
                return ['__media_error' => 'No se pudo guardar el archivo en el servidor.'];
            }

            if ($tool && $tool->media_path && Storage::disk('public')->exists($tool->media_path)) {
                Storage::disk('public')->delete($tool->media_path);
            }

            return [
                'media_path' => $path,
                'media_mime' => $file->getClientMimeType(),
                'media_original_name' => $file->getClientOriginalName(),
                'media_size_bytes' => $file->getSize(),
                'media_active' => $active,
            ];
        }

        if ($tool && $toggleRequested) {
            $out['media_active'] = $active;
        }

        return $out;
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
            'media' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,image/gif', 'max:8192'],
            'media_active' => ['nullable', 'boolean'],
            'media_remove' => ['nullable', 'boolean'],
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


