<?php

namespace Tests\Feature\Api\Admin\RealEstate;

use App\Http\Resources\Api\Admin\RealEstate\FeaturesResource;
use App\Models\Admin;
use App\Models\RealEstate\Features;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\Api\ApiTestCase;

class FeaturesTest extends ApiTestCase
{
	protected string $baseRouteName = 'api.admin.real-estate.features';

	public function setUp(): void
	{
		parent::setUp();
		
		Sanctum::actingAs(Admin::factory()->asSuperAdmin()->create(), ['*'], 'admin');
	}

	private function payload(array $attributes = [])
    {
        return $attributes + Features::factory()->raw();
    }

	private function assertModelAttributes(Features $feature, array $attributes)
    {
        foreach($attributes as $key => $value) {
			$this->assertEquals($value, $feature->{$key});
        }
    }

	/** @test */
	public function can_get_features_index()
	{
		$features = Features::factory(5)->create();

		$response = $this->get($this->getRoute('index'))
            ->assertOk()
            ->json();

        $this->assertEquals(
            FeaturesResource::collection($features->sortBy('name'))->resolve(),
            $response['data']
        );
	}

	/** @test */
	public function can_create_a_new_feature()
	{
		$payload = $this->payload();

		$response = $this->post($this->getRoute('store'), $payload)
            ->assertStatus(201)
            ->json();

        $feature = Features::findOrFail($response['data']['id']);
        $this->assertModelAttributes($feature, $payload);
	}

	/** @test */
	public function can_update_a_feature()
	{
		$feature = Features::factory()->create();
		$payload = $this->payload();

		$response = $this->put($this->getRoute('update', $feature->id), $payload)
            ->assertOk()
            ->json();

        $feature = Features::findOrFail($response['data']['id']);
        $this->assertModelAttributes($feature, $payload);
	}

	/** @test */
	public function can_destroy_a_feature()
	{
		$featureId = Features::factory()->create()->id;

		$this->delete($this->getRoute('destroy', $featureId))
			->assertStatus(204);

        $this->assertNull(Features::find($featureId));
	}
}
