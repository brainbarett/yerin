<?php

namespace Tests\Feature\Api;

use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

abstract class ApiTestCase extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected string $baseRouteName;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesSeeder::class);

        $this->withoutExceptionHandling()
            ->withHeaders(['Accept' => 'application/json']);
    }

    protected function getRoute(string $endpointName, string|array $parameters = [])
    {
        return route(
            "{$this->baseRouteName}.{$endpointName}",
            is_array($parameters) ? $parameters : [$parameters]
        );
    }
}
