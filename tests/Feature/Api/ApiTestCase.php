<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

abstract class ApiTestCase extends TestCase
{
	use RefreshDatabase;
	use WithFaker;

	public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling()
			->withHeaders(['Accept' => 'application/json']);
    }
	
	protected string $baseRouteName;

    protected function getRoute(string $endpointName, string | array $parameters = [])
    {
        return route(
            "{$this->baseRouteName}.$endpointName",
            is_array($parameters) ? $parameters : [$parameters]
        );
    }
}
