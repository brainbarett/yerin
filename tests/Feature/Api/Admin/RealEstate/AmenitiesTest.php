<?php

namespace Tests\Feature\Api\Admin\RealEstate;

use App\Http\Resources\Api\Admin\RealEstate\AmenitiesResource;
use App\Models\RealEstate\Amenities;
use App\Models\Users;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\Api\ApiTestCase;

class AmenitiesTest extends ApiTestCase
{
    protected string $baseRouteName = 'api.admin.real-estate.amenities';

    public function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(Users::factory()->asSuperAdmin()->create(), ['*'], 'admin');
    }

    /** @test */
    public function can_get_amenities_index()
    {
        $amenities = Amenities::factory(5)->create();

        $response = $this->get($this->getRoute('index'))
            ->assertOk()
            ->json();

        $this->assertEquals(
            AmenitiesResource::collection($amenities->sortBy('name'))->resolve(),
            $response['data']
        );
    }

    /** @test */
    public function can_create_a_new_amenity()
    {
        $payload = $this->payload();

        $response = $this->post($this->getRoute('store'), $payload)
            ->assertStatus(201)
            ->json();

        $amenity = Amenities::findOrFail($response['data']['id']);
        $this->assertModelAttributes($amenity, $payload);
    }

    /** @test */
    public function can_update_an_amenity()
    {
        $amenity = Amenities::factory()->create();
        $payload = $this->payload();

        $response = $this->put($this->getRoute('update', $amenity->id), $payload)
            ->assertOk()
            ->json();

        $amenity = Amenities::findOrFail($response['data']['id']);
        $this->assertModelAttributes($amenity, $payload);
    }

    /** @test */
    public function can_destroy_an_amenity()
    {
        $amenityId = Amenities::factory()->create()->id;

        $this->delete($this->getRoute('destroy', $amenityId))
            ->assertStatus(204);

        $this->assertNull(Amenities::find($amenityId));
    }

    private function payload(array $attributes = [])
    {
        return $attributes + Amenities::factory()->raw();
    }

    private function assertModelAttributes(Amenities $amenity, array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->assertEquals($value, $amenity->{$key});
        }
    }
}
