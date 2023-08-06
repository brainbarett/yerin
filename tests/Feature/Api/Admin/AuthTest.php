<?php

namespace Tests\Feature\Api\Admin;

use App\Http\Resources\Api\Admin\AdminResource;
use App\Models\Admin;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\Api\ApiTestCase;

class AuthTest extends ApiTestCase
{
    protected string $baseRouteName = 'api.admin.auth';

	/** @test */
    public function can_login()
    {
        $admin = Admin::factory()->create();
        
        $response = $this->post($this->getRoute('login'), ['email' => $admin->email, 'password' => 'password'])
            ->assertOk()
            ->json();

        $this->assertTrue(auth('admin')->check());
        $this->assertEquals(
            AdminResource::make($admin)->resolve(),
            $response['data']
        );
    }

	/** @test */
	public function can_verify_if_we_are_logged_in()
	{
		$admin = Admin::factory()->create();

		Sanctum::actingAs($admin, [], 'admin');

		$response = $this->get($this->getRoute('authenticated'))
			->assertOk()
			->json();

		$this->assertTrue(auth('admin')->check());
		$this->assertEquals(
			AdminResource::make($admin)->resolve(),
			$response['data']
		);
	}
}

