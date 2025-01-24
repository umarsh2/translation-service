<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Translation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $translations = Translation::factory(100000)->create();

        // Attach random tags to each translation
        $translations = Translation::all();
        $translations->each(function ($translation) {
            $tags = Tag::inRandomOrder()->take(rand(1, 3))->pluck('id'); // Random 1-3 tags
            $translation->tags()->attach($tags);
        });
    }
}
