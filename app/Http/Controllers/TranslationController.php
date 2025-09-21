<?php

namespace App\Http\Controllers;

use App\Http\Requests\TranslationFormRequest;
use App\Http\Resources\TranslationResource;
use App\Models\TranslationKey;
use App\Models\TranslationsCache;
use App\Services\TranslationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TranslationController extends Controller
{

    protected TranslationService $service;

    public function __construct(TranslationService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index()
    {
        $keys = request()->get('keys');
        $tags = request()->get('tags');
        $perPage = 50;

        $translations = $this->service->getTranslations(keys: $keys, tags: $tags, perPage: $perPage);
        return new TranslationResource($translations);
    }

    /**
     * @throws \Throwable
     */
    public function store(TranslationFormRequest $request)
    {
        try {
            $this->service->saveTranslation($request->validated());
            return response()->json(['message' => 'Translation saved successfully'], 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(TranslationFormRequest $request, $translationKey)
    {
        try {
            $translationKey = TranslationKey::where('key', $translationKey)->firstOrFail();
            $this->service->updateTranslation($translationKey, $request->validated());
            return response()->json(['message' => 'Translation updated successfully'], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Translation Key not found'], 500);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($translationKey)
    {
        try {
            $this->service->deleteTranslation($translationKey);
            return response()->json(['message' => 'Translation deleted successfully'], 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getJsonExport($lang)
    {
        $translations = Cache::remember('translations-' . $lang, 60, function () use ($lang) {
            return TranslationsCache::where('language_code', $lang)->first();
        });

        $fileName = "translations_{$lang}.json";
        $data = $translations['content'];
        return response()->streamDownload(function () use ($data, $fileName) {
            echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, $fileName, [
            'Content-Type' => 'application/json',
        ]);
    }

}
