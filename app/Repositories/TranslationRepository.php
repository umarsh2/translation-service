<?php

namespace App\Repositories;

use App\Models\Translation;
use Illuminate\Support\Collection;

class TranslationRepository
{
    public function create(array $data): Translation
    {
        $translation = Translation::create([
            'key' => $data['key'],
            'content' => $data['content'],
            'locale' => $data['locale'],
        ]);

        if (!empty($data['tags'])) {
            $translation->tags()->attach($data['tags']);
        }

        return $translation->load(['tags:id,name']);
    }

    public function update(int $id, array $data): Translation
    {
        $translation = Translation::findOrFail($id);
        $translation->update($data);

        if (isset($data['tags'])) {
            $translation->tags()->sync($data['tags']);
        }

        return $translation;
    }

    public function find(int $id): ?Translation
    {
        return Translation::with('tags')->find($id);
    }

    public function search(array $filters = [])
    {
        $translations = Translation::query();

        // exact match for locale...
        if (!empty($filters['locale'])) {
            $translations->where('locale', $filters['locale']);
        }

        // exact match for key...
        if (!empty($filters['key'])) {
            $translations->where('key', $filters['key']);
        }


        // partial match for content...
        if (!empty($filters['content'])) {
            $content = $filters['content'];
            $translations->where(function ($q) use ($content) {
                $q->where('content', 'like', "%$content%");
            });
        }


        if (!empty($filters['tags'])) {
            $translations->whereHas('tags', function ($q) use ($filters) {
                $q->where('name', $filters['tags']);
            });
        }


        // Apply pagination here
        return $translations->with(['tags:id,name'])->paginate(request()->per_page);
    }

    public function exportTranslations(string $locale): array
    {
        return Translation::with('tags')
            ->where('locale', $locale)
            ->get()
            ->map(function ($translation) {
                return [
                    'key' => $translation->key,
                    'content' => $translation->content,
                    'tags' => $translation->tags->pluck('name')->toArray(),
                ];
            })->toArray();
    }
}
