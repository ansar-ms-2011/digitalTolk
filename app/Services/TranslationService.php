<?php

namespace App\Services;

use App\Models\TranslationKey;
use App\Repositories\TranslationRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

class TranslationService
{
    protected TranslationRepository $repository;

    public function __construct(TranslationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getTranslations(?array $keys = null, ?array $tags = null, int $perPage = 50): LengthAwarePaginator
    {
        return $this->repository->getTranslations(keys: $keys, tags: $tags, perPage: $perPage);
    }

    /**
     * @throws Throwable
     */
    public function saveTranslation(array $data): TranslationKey
    {
        return $this->repository->saveTranslation($data);
    }

    /**
     * @throws Throwable
     */
    public function updateTranslation(TranslationKey $translationKey, array $data): TranslationKey
    {
        return $this->repository->updateTranslation($translationKey, $data);
    }

    /**
     * @throws Throwable
     */
    public function deleteTranslation(string $key)
    {
        return $this->repository->deleteTranslation($key);
    }
}
