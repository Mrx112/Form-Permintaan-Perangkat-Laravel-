<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AvatarUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_avatar()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('profile.update'), [
                'name' => 'New Name',
                'avatar' => UploadedFile::fake()->image('avatar.jpg'),
            ])
            ->assertRedirect(route('profile.edit'));

        $user->refresh();
        $this->assertNotNull($user->avatar);
    }

    public function test_invalid_avatar_is_rejected()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('profile.update'), [
                'avatar' => UploadedFile::fake()->create('file.txt', 10, 'text/plain')
            ])
            ->assertSessionHasErrors('avatar');
    }
}
