<?php

namespace Tests\Feature\Ums;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class AuthTest extends TestCase
{
    public function test_login_form()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_staff_login_redirects_to_staff_dashboard()
    {
        $response = $this->post('/login', [
            'username' => 'E0270',
            'password' => 'asdfasdf'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/staff/dashboard');
    }

    public function test_login_redirects_to_customer_dashboard()
    {
        $response = $this->post('/login', [
            'username' => 'ghost.test@gmail.com',
            'password' => 'asdfasdf'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/home');
    }

    public function test_unauthenticated_user_cannot_access_loans()
    {
        $response = $this->get('/loans');
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    public function test_authenticated_user_can_access_loans()
    {
        $user = User::where('unique_id', '=', 'E0270')->first();
        $response = $this->actingAs($user)->get('/loans');
        $response->assertStatus(200);
        //$response->assertRedirect('login');
    }
}
