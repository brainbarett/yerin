<?php

namespace Tests\Feature\Api\Admin;

use App\Http\Resources\Api\Admin\UsersResource;
use App\Models\Users;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\Api\ApiTestCase;

class AuthTest extends ApiTestCase
{
    protected string $baseRouteName = 'api.admin.auth';

    /** @test */
    public function can_login()
    {
        $user = Users::factory()->create(['password' => 'password']);

        $response = $this->post($this->getRoute('login'), ['email' => $user->email, 'password' => 'password'])
            ->assertOk()
            ->json();

        $this->assertTrue(auth('admin')->check());
        $this->assertEquals(
            UsersResource::make($user)->resolve(),
            $response['data']
        );
    }

    /** @test */
    public function can_verify_if_we_are_logged_in()
    {
        $user = Users::factory()->create();

        Sanctum::actingAs($user, [], 'admin');

        $response = $this->get($this->getRoute('authenticated'))
            ->assertOk()
            ->json();

        $this->assertTrue(auth('admin')->check());
        $this->assertEquals(
            UsersResource::make($user)->resolve(),
            $response['data']
        );
    }

    /** @test */
    public function can_logout()
    {
        Sanctum::actingAs(Users::factory()->create(), ['*'], 'admin');

        $this->post($this->getRoute('logout'))
            ->assertStatus(204);

        $this->assertFalse(auth('admin')->check());
    }
}
