<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteMedia;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class DashboardController extends Controller
{
    private const MEDIA_MAX_KB = 40960;
    private const IMAGE_MAX_WIDTH = 900;
    private const IMAGE_MAX_HEIGHT = 500;
    private const IMAGE_WEBP_QUALITY = 75;
    private const VIDEO_MIN_SECONDS = 3;
    private const VIDEO_MAX_SECONDS = 30;
    private const MEDIA_MIMES = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/gif',
        'video/mp4',
        'video/webm',
    ];

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
        $data['currency']   = $data['currency'] ?? 'PEN';

        $data = $this->normalizeOldPrices($data, $request);
        $data = $this->normalizeOffValues($data, $request);

        $data['highlights'] = $this->parseLines($request->input('highlights_text'));
        $data['extras']     = $this->parseLines($request->input('extras_text'));
        $data['includes']   = $this->parseIncludeLines($request->input('includes_text'));

        $hasFile = $request->hasFile('media');
        try {
            $mediaData = $this->processToolMedia($request, null);
            if (isset($mediaData['__media_error'])) {
                return back()->withErrors(['media' => $mediaData['__media_error']]);
            }
            if ($hasFile && empty($mediaData['media_path'])) {
                return back()->withErrors(['media' => 'No se pudo guardar el archivo. Intenta nuevamente.']);
            }
        } catch (Throwable $e) {
            \Log::error('tool_media_store_failed', [
                'context' => 'store',
                'message' => $e->getMessage(),
            ]);

            return back()->withErrors(['media' => 'No se pudo guardar el archivo multimedia. Revisa el formato o intenta con un archivo más liviano.']);
        }

        if ($request->hasFile('media')) {
            $request->session()->flash('debug_media_store', [
                'context' => 'store',
                'tool_id' => null,
                'hasFile' => $request->hasFile('media'),
                'media_path' => $mediaData['media_path'] ?? null,
                'exists' => isset($mediaData['media_path'])
                    ? $this->mediaPathExists($mediaData['media_path'])
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

        try {
            $tool = Tool::create(array_merge($data, $mediaData));
        } catch (Throwable $e) {
            \Log::error('tool_create_failed', [
                'message' => $e->getMessage(),
            ]);

            return back()->withErrors(['pack' => 'No se pudo guardar el pack. Revisa los datos e intenta nuevamente.']);
        }

        return back()->with($this->packFlashMessages($tool, $mediaData, $hasFile, 'creado'));
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
        $data['currency']   = $data['currency'] ?? ($tool->currency ?? 'PEN');

        $data = $this->normalizeOldPrices($data, $request);
        $data = $this->normalizeOffValues($data, $request);

        $data['highlights'] = $this->parseLines($request->input('highlights_text'));
        $data['extras']     = $this->parseLines($request->input('extras_text'));
        $data['includes']   = $this->parseIncludeLines($request->input('includes_text'));

        $hasFile = $request->hasFile('media');
        try {
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
        } catch (Throwable $e) {
            \Log::error('tool_media_store_failed', [
                'context' => 'update',
                'tool_id' => $tool->id,
                'message' => $e->getMessage(),
            ]);

            return back()->withErrors(['media' => 'No se pudo guardar el archivo multimedia. Revisa el formato o intenta con un archivo más liviano.']);
        }

        if ($request->hasFile('media')) {
            $request->session()->flash('debug_media_store', [
                'context' => 'update',
                'tool_id' => $tool->id,
                'hasFile' => $request->hasFile('media'),
                'media_path' => $mediaData['media_path'] ?? null,
                'exists' => isset($mediaData['media_path'])
                    ? $this->mediaPathExists($mediaData['media_path'])
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

        try {
            $tool->update(array_merge($data, $mediaData));
            $tool->refresh();
        } catch (Throwable $e) {
            \Log::error('tool_update_failed', [
                'tool_id' => $tool->id,
                'message' => $e->getMessage(),
            ]);

            return back()->withErrors(['pack' => 'No se pudo actualizar el pack. Revisa los datos e intenta nuevamente.']);
        }

        return back()->with($this->packFlashMessages($tool, $mediaData, $hasFile, 'actualizado'));
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
            'media' => ['nullable', 'file', 'mimetypes:' . implode(',', self::MEDIA_MIMES), 'max:' . self::MEDIA_MAX_KB],
            'media_active' => ['nullable', 'boolean'],
            'media_remove' => ['nullable', 'boolean'],
            'media_selected' => ['nullable'],
            'media_toggle' => ['nullable', 'boolean'],
        ], $this->mediaValidationMessages());
        $data['media_active'] = $request->boolean('media_active');

        try {
            $mediaData = $this->processToolMedia($request, $tool);
            if (isset($mediaData['__media_error'])) {
                return back()->withErrors(['media' => $mediaData['__media_error']]);
            }
        } catch (Throwable $e) {
            \Log::error('tool_media_update_failed', [
                'tool_id' => $tool->id,
                'message' => $e->getMessage(),
            ]);

            return back()->withErrors(['media' => 'No se pudo guardar el archivo multimedia. Revisa el formato o intenta con un archivo más liviano.']);
        }

        if (($hasFile || $hasRemove || $hasToggle) && !empty($mediaData)) {
            try {
                $tool->update($mediaData);
                $tool->refresh();
            } catch (Throwable $e) {
                \Log::error('tool_media_model_update_failed', [
                    'tool_id' => $tool->id,
                    'message' => $e->getMessage(),
                ]);

                return back()->withErrors(['media' => 'El archivo se procesó, pero no se pudo actualizar el pack. Intenta nuevamente.']);
            }
            \Log::info('tool_media_updated', [
                'tool_id' => $tool->id,
                'saved_path' => $tool->media_path,
                'saved_active' => $tool->media_active,
            ]);
        }

        return back()
            ->with($this->mediaFlashMessages($tool, $mediaData, $hasFile, $hasRemove))
            ->with('status_media_tool_id', $tool->id);
    }

    public function deleteToolMedia(Tool $tool)
    {
        $this->deleteMediaPath($tool->media_path);

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
        $this->deleteMediaPath($tool->media_path);
        $tool->delete();
        return back()->with('status', '🗑️ Pack eliminado');
    }

    public function updateTopMedia(Request $request)
    {
        $data = $request->validate([
            'media' => [
                'nullable',
                'file',
                'mimetypes:' . implode(',', self::MEDIA_MIMES),
                'max:' . self::MEDIA_MAX_KB,
            ],
            'active' => ['nullable', 'boolean'],
        ], $this->mediaValidationMessages());

        // Auto-activate when a new file is uploaded to avoid "uploaded but hidden" confusion.
        $active = $request->hasFile('media') ? true : $request->boolean('active');
        $existing = SiteMedia::where('key', 'tools_top_media')->first();

        if (!$request->hasFile('media') && !$existing) {
            return back()->with('status', 'Info: sube un video para activar la tarjeta');
        }

        if ($request->hasFile('media')) {
            $file = $data['media'];
            $mediaData = $this->storeOptimizedMediaFile($file, 'tools-top-');
            if (isset($mediaData['__media_error'])) {
                return back()->withErrors(['media' => $mediaData['__media_error']]);
            }

            $this->deleteMediaPath($existing?->path);

            SiteMedia::updateOrCreate(
                ['key' => 'tools_top_media'],
                [
                    'path' => $mediaData['path'],
                    'mime' => $mediaData['mime'],
                    'original_name' => $file->getClientOriginalName(),
                    'size_bytes' => $mediaData['size'],
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
            $this->deleteMediaPath($existing->path);
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
            $this->deleteMediaPath($tool->media_path);
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
            $stored = $this->storeOptimizedMediaFile($file, 'tool-media-');
            if (isset($stored['__media_error'])) {
                return ['__media_error' => $stored['__media_error']];
            }
            \Log::info('tool_media_store', [
                'tool_id' => $tool?->id,
                'path' => $stored['path'],
                'exists' => $this->mediaPathExists($stored['path']),
                'original_size' => $file->getSize(),
                'stored_size' => $stored['size'],
                'mime' => $stored['mime'],
            ]);
            if (!$this->mediaPathExists($stored['path'])) {
                return ['__media_error' => 'No se pudo guardar el archivo en el servidor.'];
            }

            if ($tool && $tool->media_path) {
                $this->deleteMediaPath($tool->media_path);
            }

            return [
                'media_path' => $stored['path'],
                'media_mime' => $stored['mime'],
                'media_original_name' => $file->getClientOriginalName(),
                'media_size_bytes' => $stored['size'],
                'media_active' => $active,
            ];
        }

        if ($tool && $toggleRequested) {
            $out['media_active'] = $active;
        }

        return $out;
    }

    private function storeOptimizedMediaFile(UploadedFile $file, string $prefix): array
    {
        $mime = $file->getClientMimeType();
        $this->ensureMediaDirectories();

        if (Str::startsWith($mime, 'image/') && $mime !== 'image/gif') {
            return $this->storeImageAsWebp($file, $prefix);
        }

        if (Str::startsWith($mime, 'video/')) {
            $ext = strtolower($file->getClientOriginalExtension() ?: ($mime === 'video/webm' ? 'webm' : 'mp4'));
            $path = 'media/' . $prefix . Str::uuid() . '.' . $ext;
            $publicPath = $this->mediaPublicPath($path);
            $legacyPath = $this->mediaLegacyPath($path);

            if (!$file->move(dirname($publicPath), basename($publicPath))) {
                return ['__media_error' => 'No se pudo guardar el video.'];
            }

            $this->mirrorMediaFile($publicPath, $legacyPath);

            return [
                'path' => $path,
                'mime' => $mime,
                'size' => $this->mediaFileSize($path),
            ];
        }

        if ($mime === 'image/gif') {
            $path = 'media/' . $prefix . Str::uuid() . '.gif';
            $publicPath = $this->mediaPublicPath($path);
            $legacyPath = $this->mediaLegacyPath($path);

            if (!$file->move(dirname($publicPath), basename($publicPath))) {
                return ['__media_error' => 'No se pudo guardar el GIF.'];
            }

            $this->mirrorMediaFile($publicPath, $legacyPath);

            return [
                'path' => $path,
                'mime' => $mime,
                'size' => $this->mediaFileSize($path),
            ];
        }

        return ['__media_error' => 'Formato no permitido. Usa JPG, PNG, WebP, GIF, MP4 o WebM.'];
    }

    private function storeImageAsWebp(UploadedFile $file, string $prefix): array
    {
        if (!function_exists('imagewebp')) {
            return ['__media_error' => 'El servidor no tiene soporte WebP en PHP/GD.'];
        }

        $source = $this->createImageResource($file);
        if (!$source) {
            return ['__media_error' => 'No se pudo procesar la imagen. Usa JPG, PNG o WebP válido.'];
        }

        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);
        $target = imagecreatetruecolor(self::IMAGE_MAX_WIDTH, self::IMAGE_MAX_HEIGHT);
        imagealphablending($target, true);
        imagesavealpha($target, true);
        $transparent = imagecolorallocatealpha($target, 0, 0, 0, 127);
        imagefilledrectangle($target, 0, 0, self::IMAGE_MAX_WIDTH, self::IMAGE_MAX_HEIGHT, $transparent);

        imagecopyresampled(
            $target,
            $source,
            0,
            0,
            0,
            0,
            self::IMAGE_MAX_WIDTH,
            self::IMAGE_MAX_HEIGHT,
            $sourceWidth,
            $sourceHeight
        );

        $tempPath = tempnam(sys_get_temp_dir(), 'media-webp-');
        if (!$tempPath || !imagewebp($target, $tempPath, self::IMAGE_WEBP_QUALITY)) {
            imagedestroy($source);
            imagedestroy($target);
            return ['__media_error' => 'No se pudo optimizar la imagen a WebP.'];
        }

        imagedestroy($source);
        imagedestroy($target);

        $path = 'media/' . $prefix . Str::uuid() . '.webp';
        $publicPath = $this->mediaPublicPath($path);
        $legacyPath = $this->mediaLegacyPath($path);
        $stored = copy($tempPath, $publicPath);
        @unlink($tempPath);

        if (!$stored) {
            return ['__media_error' => 'No se pudo guardar la imagen optimizada.'];
        }

        $this->mirrorMediaFile($publicPath, $legacyPath);

        return [
            'path' => $path,
            'mime' => 'image/webp',
            'size' => $this->mediaFileSize($path),
        ];
    }

    private function ensureMediaDirectories(): void
    {
        foreach ([$this->mediaPublicDirectory(), $this->mediaLegacyDirectory()] as $directory) {
            if (!is_dir($directory)) {
                @mkdir($directory, 0775, true);
            }
        }
    }

    private function mediaPublicDirectory(): string
    {
        return public_path('storage/media');
    }

    private function mediaLegacyDirectory(): string
    {
        return storage_path('app/public/media');
    }

    private function mediaPublicPath(string $relativePath): string
    {
        return public_path('storage/' . ltrim($relativePath, '/'));
    }

    private function mediaLegacyPath(string $relativePath): string
    {
        return storage_path('app/public/' . ltrim($relativePath, '/'));
    }

    private function mediaPathExists(string $relativePath): bool
    {
        return file_exists($this->mediaPublicPath($relativePath))
            || file_exists($this->mediaLegacyPath($relativePath));
    }

    private function mediaFileSize(string $relativePath): int
    {
        $publicPath = $this->mediaPublicPath($relativePath);
        if (file_exists($publicPath)) {
            return (int) filesize($publicPath);
        }

        $legacyPath = $this->mediaLegacyPath($relativePath);
        if (file_exists($legacyPath)) {
            return (int) filesize($legacyPath);
        }

        return 0;
    }

    private function mirrorMediaFile(string $publicPath, string $legacyPath): void
    {
        $publicDir = dirname($publicPath);
        $legacyDir = dirname($legacyPath);

        if (!is_dir($legacyDir)) {
            @mkdir($legacyDir, 0775, true);
        }

        $publicReal = realpath($publicDir);
        $legacyReal = realpath($legacyDir);

        if ($publicReal && $legacyReal && $publicReal === $legacyReal) {
            return;
        }

        if (file_exists($publicPath)) {
            @copy($publicPath, $legacyPath);
        }
    }

    private function deleteMediaPath(?string $relativePath): void
    {
        if (!$relativePath) {
            return;
        }

        $paths = array_values(array_unique([
            $this->mediaPublicPath($relativePath),
            $this->mediaLegacyPath($relativePath),
        ]));

        foreach ($paths as $path) {
            if (file_exists($path)) {
                @unlink($path);
            }
        }
    }

    private function createImageResource(UploadedFile $file)
    {
        $path = $file->getRealPath();
        return match ($file->getClientMimeType()) {
            'image/jpeg' => @imagecreatefromjpeg($path),
            'image/png' => @imagecreatefrompng($path),
            'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
            default => false,
        };
    }

    private function packFlashMessages(Tool $tool, array $mediaData, bool $submittedFile, string $action): array
    {
        $messages = [
            $action === 'creado'
                ? 'Pack guardado correctamente.'
                : 'Pack actualizado correctamente.',
        ];

        $warnings = [];
        $mediaPath = $mediaData['media_path'] ?? null;
        $mediaMime = $mediaData['media_mime'] ?? null;
        $mediaName = $mediaData['media_original_name'] ?? null;

        if ($mediaPath) {
            $fileLabel = $mediaName ? basename($mediaName) : basename($mediaPath);
            if (Str::startsWith((string) $mediaMime, 'image/')) {
                $messages[] = "Imagen guardada correctamente: {$fileLabel}.";
            } elseif (Str::startsWith((string) $mediaMime, 'video/')) {
                $messages[] = "Video guardado correctamente: {$fileLabel}.";
                $warnings[] = 'Video guardado en modo compatible, sin compresión automática.';
            } else {
                $messages[] = "Archivo multimedia guardado correctamente: {$fileLabel}.";
            }
        } elseif ($submittedFile) {
            $warnings[] = 'El pack se guardó, pero no se registró archivo multimedia.';
        } elseif ($tool->media_path) {
            $warnings[] = 'No se subió archivo nuevo; se mantiene el multimedia actual.';
        } else {
            $warnings[] = 'Pack guardado sin archivo multimedia.';
        }

        $messages[] = $tool->is_active
            ? 'Pack publicado correctamente.'
            : 'Pack guardado como no publicado.';

        return [
            'status' => implode(' ', $messages),
            'flash_success' => $messages,
            'flash_warning' => $warnings,
            'status_tool_id' => $tool->id,
        ];
    }

    private function mediaFlashMessages(Tool $tool, array $mediaData, bool $submittedFile, bool $removed): array
    {
        $messages = [];
        $warnings = [];

        if ($removed) {
            $messages[] = 'Archivo multimedia eliminado correctamente.';
        } elseif (($mediaData['media_path'] ?? null) && $submittedFile) {
            $fileLabel = basename($mediaData['media_original_name'] ?? $mediaData['media_path']);
            if (Str::startsWith((string) ($mediaData['media_mime'] ?? ''), 'image/')) {
                $messages[] = "Imagen guardada correctamente: {$fileLabel}.";
            } elseif (Str::startsWith((string) ($mediaData['media_mime'] ?? ''), 'video/')) {
                $messages[] = "Video guardado correctamente: {$fileLabel}.";
                $warnings[] = 'Video guardado en modo compatible, sin compresión automática.';
            } else {
                $messages[] = "Archivo multimedia guardado correctamente: {$fileLabel}.";
            }
        } elseif (array_key_exists('media_active', $mediaData)) {
            $messages[] = $tool->media_active
                ? 'Archivo multimedia activado correctamente.'
                : 'Archivo multimedia desactivado correctamente.';
        } else {
            $warnings[] = 'No se guardó ningún archivo multimedia nuevo.';
        }

        return [
            'status' => implode(' ', $messages ?: ['Cambio de media procesado.']),
            'flash_success' => $messages,
            'flash_warning' => $warnings,
            'status_tool_id' => $tool->id,
        ];
    }

    private function validateTool(Request $request): array
    {
        $data = $request->validate([
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
            'currency' => ['nullable', Rule::in(['PEN', 'USD'])],
            'media' => ['nullable', 'file', 'mimetypes:' . implode(',', self::MEDIA_MIMES), 'max:' . self::MEDIA_MAX_KB],
            'media_active' => ['nullable', 'boolean'],
            'media_remove' => ['nullable', 'boolean'],
        ], $this->mediaValidationMessages());

        $data['media_active'] = $request->boolean('media_active');
        $data['currency'] = strtoupper($data['currency'] ?? 'PEN');

        return $data;
    }

    private function mediaValidationMessages(): array
    {
        return [
            'media.mimetypes' => 'Formato no permitido. Usa JPG, PNG, WebP, GIF, MP4 o WebM.',
            'media.max' => 'El archivo supera 40MB. Comprime el archivo antes de subirlo.',
            'media.file' => 'El archivo no se pudo leer correctamente. Vuelve a seleccionarlo.',
        ];
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





