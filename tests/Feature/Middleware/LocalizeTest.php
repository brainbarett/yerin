<?php

namespace Tests\Feature\Middleware;

use App\Http\Middleware\Localize;
use App\Models\Users;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LocalizeTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;
	
	public function testHandle()
	{
		$request = new Request;
		$middleware = new Localize;
        app()->setLocale('en');

        $request->headers->set('X-Language', 'es');
        $middleware->handle($request, function(Request $request) {
            $this->assertEquals('es', $request->headers->get('Content-Language'));
        });
        $this->assertEquals('es', app()->getLocale());
	}

    public function testHandlePrioritizesUserSavedPreference()
    {
        $request = new Request;
		$middleware = new Localize;
		app()->setLocale('en');
		
        Sanctum::actingAs(Users::factory()->create(['language' => 'es']), [], 'admin');
        $request->headers->set('X-Language', 'en');

        $middleware->handle($request, function(Request $request) {
            $this->assertEquals('es', $request->headers->get('Content-Language'));
        });
        $this->assertEquals('es', app()->getLocale());
    }
}
