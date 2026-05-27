<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_login_screen_is_available(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('Correo');
        $response->assertSee('Entrar');
    }

    public function test_dashboard_redirects_guests_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }
}
