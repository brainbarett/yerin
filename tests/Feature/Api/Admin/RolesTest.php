<?php

namespace Tests\Feature\Api\Admin;

use App\Http\Resources\Api\Admin\RolesResource;
use App\Models\Permissions;
use App\Models\Roles;
use App\Models\Users;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\Api\ApiTestCase;

class RolesTest extends ApiTestCase
{
    protected string $baseRouteName = 'api.admin.roles';

    private Users $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = Users::factory()->asSuperAdmin()->create();

        Sanctum::actingAs($this->user, ['*'], 'admin');
    }

    /** @test */
    public function can_get_roles_index()
    {
        $roles = Roles::all()
            ->merge(Roles::factory(3)->create());

        $response = $this->get($this->getRoute('index'))
            ->assertOk()
            ->json();

        $this->assertEqualsCanonicalizing(
            RolesResource::collection($roles)->resolve(),
            $response['data']
        );
    }

    /** @test */
    public function can_get_specific_role()
    {
        $role = Roles::factory()->create();

        $response = $this->get($this->getRoute('show', $role->id))
            ->assertOk()
            ->json();

        $this->assertEquals(RolesResource::make($role)->resolve(), $response['data']);
    }

    /** @test */
    public function can_create_new_roles()
    {
        $payload = $this->payload();

        $response = $this->post($this->getRoute('store'), $payload)
            ->assertStatus(201)
            ->json();

        $role = Roles::findOrFail($response['data']['id']);
        $this->assertEquals($payload['name'], $role->name);
        $this->assertEqualsCanonicalizing(
            $payload['permissions'],
            $role->permissions()->pluck('name')->toArray()
        );
    }

    /** @test */
    public function can_update_a_role()
    {
        $role = Roles::factory()->create();

        $payload = $this->payload();

        $this->put($this->getRoute('update', $role->id), $payload)
            ->assertStatus(204);

        $role->refresh();
        $this->assertEquals($payload['name'], $role->name);
        $this->assertEqualsCanonicalizing(
            $payload['permissions'],
            $role->permissions()->pluck('name')->toArray()
        );
    }

    /** @test */
    public function can_destroy_a_role()
    {
        $roleId = Roles::factory()->create()->id;

        $this->delete($this->getRoute('destroy', $roleId))
            ->assertStatus(204);

        $this->assertNull(Roles::find($roleId));
    }

    private function payload(array $attributes = [])
    {
        return $attributes + [
            'name' => $this->faker->unique()->name,
            'permissions' => Permissions::factory(3)->create()->pluck('name')->toArray(),
        ];
    }
}
