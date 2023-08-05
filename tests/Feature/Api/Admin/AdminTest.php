<?php

namespace Tests\Feature\Api\Admin;

use App\Http\Resources\Api\Admin\AdminResource;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\Api\ApiTestCase;

class AdminTest extends ApiTestCase
{
	private Admin $admin;

	protected string $baseRouteName = 'api.admin.admin';

	public function setUp(): void
	{
		parent::setUp();
		
		$this->admin = Admin::factory()->create();

		Sanctum::actingAs($this->admin, ['*'], 'admin');
	}

	private function payload(array $attributes = [])
    {
        return $attributes + Admin::factory()->raw();
    }

	private function assertModelAttributes(Admin $admin, array $attributes)
    {
        foreach($attributes as $attribute => $value) {
            switch($attribute) {
                case 'password':
                    $this->assertTrue(Hash::check($value, $admin->{$attribute}));
                    break;
                
                default:
                    $this->assertEquals($value, $admin->{$attribute});
                    break;
            }
        }
    }

	/** @test */
    public function can_get_admin_index()
    {
        $admin = Admin::factory(5)->create();
        $admin->prepend($this->admin);

        $response = $this->get($this->getRoute('index'))
            ->assertOk()
            ->json();

        $this->assertEquals(
            AdminResource::collection($admin->sortBy('name'))->resolve(),
            $response['data']
        );
    }

	/** @test */
    public function can_get_specific_admin()
    {
        $response = $this->get($this->getRoute('show', $this->admin->id))
            ->assertOk()
            ->json();

        $this->assertEquals(AdminResource::make($this->admin)->resolve(), $response['data']);
    }

	/** @test */
    public function can_create_a_new_admin()
    {
        $payload = $this->payload();

        $response = $this->post($this->getRoute('store'), $payload)
            ->assertStatus(201)
            ->json();

        $admin = Admin::findOrFail($response['data']['id']);
        $this->assertModelAttributes($admin, $payload);
    }

	/** @test */
    public function can_update_an_admin()
    {
        $admin = Admin::factory()->create();

        $payload = $this->payload();

        $this->put($this->getRoute('update', $admin->id), $payload)
            ->assertOk();
			
        $this->assertModelAttributes($admin->refresh(), $payload);
    }

	/** @test */
    public function can_destroy_an_admin()
    {
        $adminId = Admin::factory()->create()->id;

        $this->delete($this->getRoute('destroy', $adminId))
            ->assertStatus(204);

        $this->assertNull(Admin::find($adminId));
    }
}
