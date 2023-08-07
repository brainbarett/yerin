<?php

namespace Tests\Feature\Api\Admin\RealEstate;

use App\Models\Admin;
use App\Models\RealEstate\Properties;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\Api\ApiTestCase;

class PropertiesTest extends ApiTestCase
{
	private Admin $admin;

	protected string $baseRouteName = 'api.admin.real-estate.properties';

	public function setUp(): void
	{
		parent::setUp();
		
		$this->admin = Admin::factory()->create();

		Sanctum::actingAs($this->admin, ['*'], 'admin');
	}

	private function payload(array $attributes = [])
    {
        return $attributes + Properties::factory()->raw();
    }

	private function assertModelAttributes(Properties $property, array $attributes)
    {
        foreach($attributes as $key => $value) {
            switch($key) {
				case 'listings':
					foreach($value as $listingType => $priceOrTerms) {
						if($listingType == 'SALE') {
							$this->assertEquals(
								$priceOrTerms,
								$property->listings()
									->where('type', 'SALE')
									->firstOrFail()
									->price
							);
						}
						
						if($listingType == 'RENT') {
							foreach($priceOrTerms as $term => $price) {
								$this->assertEquals(
									$price,
									$property->listings()
										->where('type', 'RENT')
										->where('term', $term)
										->firstOrFail()
										->price
								);
							}
						}
					}
					break;

                default:
                    $this->assertEquals($value, $property->{$key});
                    break;
            }
        }
    }
	
    /** @test */
	public function can_create_a_new_property()
	{
		$payload = $this->payload([
			'listings' => [
				'RENT' => [
					'DAY' => $this->faker->randomNumber(3),
					'WEEK' => $this->faker->randomNumber(3),
					'MONTH' => $this->faker->randomNumber(3),
					'YEAR' => $this->faker->randomNumber(3),
				],
				'SALE' => $this->faker->randomNumber(3)
			]
		]);

		$response = $this->post($this->getRoute('store'), $payload)
            ->assertStatus(201)
            ->json();

        $property = Properties::findOrFail($response['data']['id']);
        $this->assertModelAttributes($property, $payload);
	}
}
