<?php

namespace Tests\Feature\Api\Admin;

use App\Models\GeoLocation\Cities;
use App\Models\GeoLocation\Countries;
use App\Models\GeoLocation\Sectors;
use App\Models\GeoLocation\States;
use App\Models\Users;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\Api\ApiTestCase;

class GeoLocationTest extends ApiTestCase
{
    protected string $baseRouteName = 'api.admin.geo-locations';

    public function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(Users::factory()->create(), ['*'], 'admin');
    }

    /** @test */
    public function can_get_geo_locations_index()
    {
        Sectors::factory(5)->create();

        $response = $this->get($this->getRoute('index'))
            ->assertOk()
            ->json();

        $this->assertCount(Countries::count(), $response['data']['countries']);
        $this->assertCount(States::count(), $response['data']['cities']);
        $this->assertCount(Cities::count(), $response['data']['states']);
        $this->assertCount(Sectors::count(), $response['data']['sectors']);
    }
}
