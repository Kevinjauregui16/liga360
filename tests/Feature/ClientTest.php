<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    private function makeClient(array $attributes = []): Client
    {
        $client = new Client(array_merge(['name' => 'Liga Norte', 'slug' => 'liga-norte', 'status' => 'active'], $attributes));
        $client->save();

        return $client;
    }

    public function test_guests_cannot_access_clients(): void
    {
        $this->get('/clients')->assertRedirect('/login');
    }

    public function test_client_screens_render(): void
    {
        $user = User::factory()->create();
        $client = $this->makeClient();

        $this->actingAs($user)->get('/clients')->assertOk()->assertSee('Liga Norte');
        $this->actingAs($user)->get('/clients/create')->assertOk();
        $this->actingAs($user)->get("/clients/{$client->id}")->assertOk();
        $this->actingAs($user)->get("/clients/{$client->id}/edit")->assertOk();
    }

    public function test_store_generates_slug_and_saves_logo(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)->post('/clients', [
            'name' => 'Liga Sur Fútbol',
            'email' => '',
            'status' => 'active',
            'logo' => UploadedFile::fake()->image('logo.png'),
        ])->assertRedirect('/clients');

        $client = Client::firstOrFail();
        $this->assertSame('liga-sur-futbol', $client->slug);
        $this->assertNull($client->email);
        Storage::disk('public')->assertExists($client->logo);
    }

    public function test_validation_rejects_invalid_status_and_duplicate_slug(): void
    {
        $user = User::factory()->create();
        $this->makeClient();

        $this->actingAs($user)->post('/clients', [
            'name' => 'Otra',
            'slug' => 'liga-norte',
            'status' => 'deleted',
        ])->assertSessionHasErrors(['slug', 'status']);
    }

    public function test_validation_messages_are_in_spanish(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/clients', ['email' => 'no-es-correo', 'status' => 'active'])
            ->assertSessionHasErrors([
                'name' => 'El campo nombre es obligatorio.',
                'email' => 'El campo correo electrónico no es un correo válido.',
            ]);
    }

    public function test_update_keeps_own_slug_and_replaces_logo(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $client = $this->makeClient(['logo' => UploadedFile::fake()->image('old.png')->store('clients/logos', 'public')]);
        $oldLogo = $client->logo;

        $this->actingAs($user)->put("/clients/{$client->id}", [
            'name' => 'Liga Norte',
            'slug' => 'liga-norte',
            'status' => 'suspended',
            'logo' => UploadedFile::fake()->image('new.png'),
        ])->assertRedirect('/clients')->assertSessionHasNoErrors();

        $client->refresh();
        $this->assertSame('suspended', $client->status);
        Storage::disk('public')->assertMissing($oldLogo);
        Storage::disk('public')->assertExists($client->logo);
    }

    public function test_destroy_soft_deletes(): void
    {
        $user = User::factory()->create();
        $client = $this->makeClient();

        $this->actingAs($user)->delete("/clients/{$client->id}")->assertRedirect('/clients');

        $this->assertSoftDeleted($client);
    }

    public function test_client_users_relationship(): void
    {
        $client = $this->makeClient();
        $user = User::factory()->create();
        $user->forceFill(['client_id' => $client->id])->save();

        $this->assertTrue($client->users->contains($user));
        $this->assertTrue($user->client->is($client));
    }
}
