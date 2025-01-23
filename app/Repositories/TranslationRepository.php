<?php

namespace App\Repositories;

use App\Models\Translation;

class TranslationRepository
{
    public function search(array $filters)
    {
        return Translation::query()
            ->when($filters['locale'] ?? null, fn($q, $locale) => $q->where('locale', $locale))
            ->when($filters['tags'] ?? null, fn($q, $tags) => $q->whereJsonContains('tags', $tags))
            ->when($filters['key'] ?? null, fn($q, $key) => $q->where('key', $key))
            ->when($filters['content'] ?? null, fn($q, $content) => $q->where('content', 'like', "%{$content}%"))
            ->paginate(20);
    }

    public function create(array $data)
    {
        return Translation::create($data);
    }

    public function update($id, array $data)
    {
        $translation = Translation::findOrFail($id);
        $translation->update($data);
        return $translation;
    }

    public function delete($id)
    {
        Translation::findOrFail($id)->delete();
    }

    public function export()
    {
        return Translation::all();
    }
}
