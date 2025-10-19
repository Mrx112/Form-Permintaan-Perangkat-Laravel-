<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_creates_unapproved_user_and_admin_can_approve()
    {
        // create admin
        $admin = User::factory()->create(['role' => 'admin', 'approved' => true]);

        // register new user
        $resp = $this->post(route('register.post'), [
            'name' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $resp->assertStatus(200);

        $user = User::where('email', 'newuser@example.com')->first();
        $this->assertNotNull($user);
        $this->assertFalse($user->approved);

        // admin approves user
        $this->actingAs($admin)->post(route('admin.users.store')); // ensure route exists

        // use controller approve directly
        $this->actingAs($admin)->post(route('admin.users.approve', ['user' => $user->id]));
        $user->refresh();
        $this->assertTrue($user->approved);
    }

    public function test_activation_route_marks_user_approved()
    {
        $user = User::factory()->create(['approved' => false, 'approval_token' => bin2hex(random_bytes(8))]);
        $token = $user->approval_token;

        $resp = $this->get(route('auth.activate', ['token' => $token]));
        $resp->assertStatus(200);

        $user->refresh();
        $this->assertTrue($user->approved);
        $this->assertNull($user->approval_token);
    }
}
