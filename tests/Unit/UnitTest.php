<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UnitTest extends TestCase
{
	use WithoutMiddleware;
	
    /**
     * A basic unit test to see if the application is running.
     *
     * @return void
     */
    public function testApplicationUp()
    {
		$response = $this->get('/');

		$response->assertStatus(200);
    }
	
    /**
     * A basic unit test to see if the api is available.
     *
     * @return void
     */
    public function testApiUp()
    {
		$response = $this->getJson('api/restaurants');

		$response->assertStatus(200);
    }
	
    /**
     * A basic unit test to see if the api is returning valid data.
     *
     * @return void
     */
    public function testApiValidData()
    {
		$response = $this->getJson('api/restaurants');
				
		$this->assertNotEquals('[]', $response->getContent());
    }
	
    /**
     * A basic unit test to see if the api is returning no data with invalid request.
     *
     * @return void
     */
    public function testApiInvalidData()
    {
		$response = $this->getJson('api/restaurants?search=invalid');
				
		$this->assertEquals('[]', $response->getContent());
    }
	
    /**
     * A basic unit test to see if the api is returning valid response with favorite request.
     *
     * @return void
     */
    public function testApiValidFavorite()
    {		
		$response = $this->postJson('api/restaurants/favorite', ['restaurant' => ['name' => 'Pamukkale']]);
				
		$response->assertStatus(200);
    }
	
    /**
     * A basic unit test to see if the api is throwing valid error with invalid favorite request.
     *
     * @return void
     */
    public function testApiInvalidFavorite()
    {		
		$response = $this->postJson('api/restaurants/favorite', ['invalid' => 'data']);
				
		$response->assertStatus(403);
    }
	
    /**
     * A basic unit test to see if the api is returning valid response with unfavorite request.
     *
     * @return void
     */
    public function testApiValidUnfavorite()
    {		
		$response = $this->postJson('api/restaurants/favorite', ['restaurant' => ['name' => 'Pamukkale']]);
				
		$response->assertStatus(200);
    }
	
    /**
     * A basic unit test to see if the api is throwing valid error with invalid unfavorite request.
     *
     * @return void
     */
    public function testApiInvalidUnfavorite()
    {		
		$response = $this->postJson('api/restaurants/favorite', ['invalid' => 'data']);
				
		$response->assertStatus(403);
    }
}
