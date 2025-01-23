<?php

namespace Tests\Feature;

use App\Models\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TranslationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_translation()
    {
        $response = $this->postJson('/api/translations', [
            'locale' => 'en',
            'key' => 'greeting',
            'content' => 'Hello',
            'tags' => ['web', 'common'],
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('translations', [
            'locale' => 'en',
            'key' => 'greeting',
        ]);
    }

    public function test_can_update_translation()
    {
        $translation = Translation::factory()->create();

        $response = $this->putJson("/api/translations/{$translation->id}", [
            'locale' => 'en',
            'key' => $translation->key,
            'content' => 'Updated Content',
            'tags' => ['web'],
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('translations', [
            'id' => $translation->id,
            'content' => 'Updated Content',
        ]);
    }

    public function test_can_delete_translation()
    {
        $translation = Translation::factory()->create();

        $response = $this->deleteJson("/api/translations/{$translation->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('translations', [
            'id' => $translation->id,
        ]);
    }

    public function test_can_search_translations()
    {
        Translation::factory()->create(['locale' => 'en', 'key' => 'greeting', 'content' => 'Hello']);

        $response = $this->getJson('/api/translations?locale=en&key=greeting');

        $response->assertStatus(200)
                 ->assertJsonFragment(['key' => 'greeting', 'content' => 'Hello']);
    }

    public function test_can_export_translations()
    {
        Translation::factory()->count(10)->create();

        $response = $this->getJson('/api/export');

        $response->assertStatus(200);
        $this->assertCount(10, $response->json());
    }
}
