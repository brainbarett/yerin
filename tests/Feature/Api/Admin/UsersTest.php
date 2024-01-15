<?php

namespace Tests\Feature\Api\Admin;

use App\Http\Resources\Api\Admin\UsersResource;
use App\Models\Roles;
use App\Models\Users;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\Api\ApiTestCase;

class UsersTest extends ApiTestCase
{
    protected string $baseRouteName = 'api.admin.users';

    private Users $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = Users::factory()->asSuperAdmin()->create();

        Sanctum::actingAs($this->user, ['*'], 'admin');
    }

    /** @test */
    public function can_get_users_index()
    {
        $users = Users::factory(5)->create();
        $users->prepend($this->user);

        $response = $this->get($this->getRoute('index'))
            ->assertOk()
            ->json();

        $this->assertEquals(
            UsersResource::collection($users->sortBy('name'))->resolve(),
            $response['data']
        );
    }

    /** @test */
    public function can_get_specific_a_user()
    {
        $response = $this->get($this->getRoute('show', $this->user->id))
            ->assertOk()
            ->json();

        $this->assertEquals(UsersResource::make($this->user)->resolve(), $response['data']);
    }

    /** @test */
    public function can_create_a_new_user()
    {
        $payload = $this->payload();

        $response = $this->post($this->getRoute('store'), $payload)
            ->assertStatus(201)
            ->json();

        $user = Users::findOrFail($response['data']['id']);
        $this->assertModelAttributes($user, $payload);
    }

    /** @test */
    public function can_update_an_user()
    {
        $user = Users::factory()->create();
        $payload = Arr::except($this->payload(), 'password');

        $this->put($this->getRoute('update', $user->id), $payload)
            ->assertOk();

        $this->assertModelAttributes($user->refresh(), $payload);
    }

    /** @test */
    public function can_update_a_user_password()
    {
        $user = Users::factory()->create();
        $payload = ['password' => $this->faker->sentence];

        $this->patch($this->getRoute('patch', $user->id), $payload)
            ->assertOk();

        $this->assertModelAttributes($user->refresh(), $payload);
    }

    /** @test */
    public function can_destroy_a_user()
    {
        $userId = Users::factory()->create()->id;

        $this->delete($this->getRoute('destroy', $userId))
            ->assertStatus(204);

        $this->assertNull(Users::find($userId));
    }

    /** @test */
    public function user_cannot_destroy_self()
    {
        $this->withExceptionHandling();

        $this->delete($this->getRoute('destroy', $this->user->id))
            ->assertStatus(403);

        $this->assertTrue(Users::where('id', $this->user->id)->exists());
    }

    private function payload(array $attributes = [])
    {
        return $attributes + Users::factory()->raw() + ['role' => Roles::factory()->create()->id];
    }

    private function assertModelAttributes(Users $user, array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            switch ($attribute) {
                case 'password':
                    $this->assertTrue(Hash::check($value, $user->{$attribute}));
                    break;

                case 'role':
                    $this->assertTrue($user->roles()->where('id', $value)->exists());
                    break;

                default:
                    $this->assertEquals($value, $user->{$attribute});
                    break;
            }
        }
    }
}
