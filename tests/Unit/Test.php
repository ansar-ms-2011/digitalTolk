<?php


use App\Models\TranslationKey;
use Tests\TestCase; // important!
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Test extends TestCase
{
    use RefreshDatabase;


    public function test_authenticated_user_can_access_translations()
    {
        $user = User::factory()->create();

        // Generate JWT for the user
        $token = JWTAuth::fromUser($user);

        // Hit the route with the Authorization header
        $response = $this->getJson('/api/translations', [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(200);
    }


    public function it_can_show_a_translation(): void
    {
        $translation = TranslationKey::factory()->create([
            'key' => 'welcome',
            'namespace' => 'messages',
        ]);

        $response = $this->getJson("/api/translations/{$translation->key}", $this->authHeaders());

        $response->assertStatus(200)
            ->assertJson([
                'id' => $translation->id,
                'key' => 'welcome',
                'namespace' => 'messages',
            ]);
    }
}
