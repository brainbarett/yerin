<?php

namespace Tests\Feature\Api\Admin\RealEstate;

use App\Enums\RealEstate\RentTerms;
use App\Http\Resources\Api\Admin\RealEstate\PropertiesResource;
use App\Models\Admin;
use App\Models\Images;
use App\Models\ModelImages;
use App\Models\RealEstate\Features;
use App\Models\RealEstate\Properties;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\Api\ApiTestCase;

class PropertiesTest extends ApiTestCase
{
	private Admin $admin;

	protected string $baseRouteName = 'api.admin.real-estate.properties';

	public function setUp(): void
	{
		parent::setUp();
		
		Storage::fake('uploads');
		
		$this->admin = Admin::factory()->asSuperAdmin()->create();
		Sanctum::actingAs($this->admin, ['*'], 'admin');
	}

	private function payload(array $attributes = [])
    {
        return $attributes + Properties::factory()->raw();
    }

	private function payloadVariations()
	{
		$payloadVariations = [
			// all
			$this->payload([
				'listings' => [
					'RENT' => [
						'DAY' => $this->faker->randomNumber(3),
						'WEEK' => $this->faker->randomNumber(3),
						'MONTH' => $this->faker->randomNumber(3),
						'YEAR' => $this->faker->randomNumber(3),
					],
					'SALE' => $this->faker->randomNumber(3)
				],
				'images' => Images::factory(3)->create()->map(function($image, $index) {
					return [
						'id' => $image->id,
						'order' => $index
					];
				})->toArray(),
				'features' => Features::factory(3)->create()->pluck('id')->toArray(),
			]),

			// only for sale
			$this->payload([
				'listings' => ['SALE' => $this->faker->randomNumber(3)],
				'images' => [],
				'features' => [],
			]),

			// only for rent
			$this->payload([
				'listings' => [
					'RENT' => [
						'DAY' => $this->faker->randomNumber(3),
						'WEEK' => $this->faker->randomNumber(3),
						'MONTH' => $this->faker->randomNumber(3),
						'YEAR' => $this->faker->randomNumber(3),
					],
				],
				'images' => [],
				'features' => [],
			]),

			// only images
			$this->payload([
				'images' => Images::factory(3)->create()->map(function($image, $index) {
					return [
						'id' => $image->id,
						'order' => $index
					];
				})->toArray(),
				'listings' => null,
				'features' => [],
			]),

			// only features
			$this->payload([
				'images' => [],
				'listings' => null,
				'features' => Features::factory(3)->create()->pluck('id')->toArray(),
			]),
		];

		// each specific term individually
		foreach(RentTerms::names() as $term) {
			$payloadVariations[] = $this->payload([
				'listings' => [
					'RENT' => [$term => $this->faker->randomNumber(3)],
				],
				'images' => [],
				'features' => [],
			]);
		}

		return $payloadVariations;
	}

	private function assertModelAttributes(Properties $property, array $attributes)
    {
        foreach($attributes as $key => $value) {
            switch($key) {
				case 'listings':
					if(is_null($value)) {
						$this->assertEquals(0, $property->listings()->count());
					} else {
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
					}
					break;

				case 'images':
					$this->assertEquals(
						$value,
						$property->images->map(function(ModelImages $image) {
							return [
								'id' => $image->image_id,
								'order' => $image->order
							];
						})->toArray()
					);
					break;

				case 'features':
					$this->assertEqualsCanonicalizing(
						$value,
						$property->features->pluck('id')->toArray()
					);
					break;
					
                default:
                    $this->assertEquals($value, $property->{$key});
                    break;
            }
        }
    }
	
	/** @test */
    public function can_get_properties_index()
    {
		$properties = Properties::factory(5)->withListings()->withImages()->create();

        $response = $this->get($this->getRoute('index'))
            ->assertOk()
            ->json();

        $this->assertEquals(
            PropertiesResource::collection($properties)->resolve(),
            $response['data']
        );
	}

	/** @test */
    public function can_get_paginated_properties_index()
    {
        $properties = Properties::factory(5)->create();

        $response = $this->get($this->getRoute('index', ['paginate' => 1, 'page' => 1]))
            ->assertOk()
            ->json();
            
        $this->assertEquals(
            PropertiesResource::collection($properties)->resolve(),
            $response['data']
        );
        $this->assertTrue(isset($response['links'], $response['meta']));
    }

	/** @test */
    public function can_get_specific_a_property()
    {
		$property = Properties::factory()->create();

        $response = $this->get($this->getRoute('show', $property->id))
            ->assertOk()
            ->json();

        $this->assertEquals(PropertiesResource::make($property)->resolve(), $response['data']);
    }

    /** @test */
	public function can_create_a_new_property()
	{
		foreach($this->payloadVariations() as $payload) {
			$response = $this->post($this->getRoute('store'), $payload)
				->assertStatus(201)
				->json();
	
			$property = Properties::findOrFail($response['data']['id']);
			$this->assertModelAttributes($property, $payload);
		}
	}

	/** @test */
	public function can_update_a_property()
	{
		$property = Properties::factory()->create();
	
		foreach($this->payloadVariations() as $payload) {
			$this->put($this->getRoute('update', $property->id), $payload)
				->assertOk();
	
			$this->assertModelAttributes($property->refresh(), $payload);
		}
	}

	/** @test */
    public function can_destroy_a_property()
    {
        $propertyId = Properties::factory()->create()->id;

        $this->delete($this->getRoute('destroy', $propertyId))
            ->assertStatus(204);

        $this->assertNull(Properties::find($propertyId));
    }
}
