<?php

namespace Tests\Feature\Api\Admin;

use App\Http\Resources\Api\Admin\GeoLocationsResource;
use App\Models\Admin;
use App\Models\GeoLocation\Sectors;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\Api\ApiTestCase;

class GeoLocationTest extends ApiTestCase
{
	protected string $baseRouteName = 'api.admin.geo-locations';

	public function setUp(): void
	{
		parent::setUp();
		
		Sanctum::actingAs(Admin::factory()->create(), ['*'], 'admin');
	}

    /** @test */
    public function can_get_geo_locations_index()
    {
		$sectors = Sectors::factory(5)->create();

        $response = $this->get($this->getRoute('index'))
            ->assertOk()
            ->json();

        $this->assertEquals(
            GeoLocationsResource::collection($sectors->map->country->unique())->resolve(),
            $response['data']
        );
    }
}
