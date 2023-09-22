<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('admin')
	->name('admin.')
	->middleware(['auth:sanctum', 'auth:admin'])
	->namespace('Admin')
	->group(function() {
		Route::prefix('auth')->name('auth.')->group(function() {
			Route::post('login', 'AuthController@login')
				->name('login')
				->withoutMiddleware(['auth:sanctum', 'auth:admin']);
			Route::get('authenticated', 'AuthController@isAuthenticated')->name('authenticated');
			Route::post('logout', 'AuthController@logout')->name('logout');
		});

		Route::apiResource('roles', 'RolesController')->only(['index', 'store']);

		Route::apiResource('admin', 'AdminController')->except('update');
		Route::put('admin/{admin}', 'AdminController@update')->name('admin.update');
		Route::patch('admin/{admin}', 'AdminController@patch')->name('admin.patch');

		Route::post('images', 'ImagesController@upload')->name('images.upload');
		Route::delete('images/{image}', 'ImagesController@destroy')->name('images.destroy');

		Route::get('geo-locations', 'GeoLocationsController@index')->name('geo-locations.index');

		Route::prefix('real-estate')
			->name('real-estate.')
			->namespace('RealEstate')
			->group(function() {
				Route::apiResource('features', 'FeaturesController')->except('show');
				Route::apiResource('properties', 'PropertiesController');
			});
	});
