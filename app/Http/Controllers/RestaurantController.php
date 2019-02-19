<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Faker\Factory as FakerFactory;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$faker = FakerFactory::create();
		
		$json = json_decode(\File::get(database_path('data/restaurants.json')), true);
		
        $collection = collect($json['restaurants']);
		
		$collection = $collection->map(function($collection) use ($faker){
			$collection['address']							= $faker->address;
			
			$collection['telephone']						= $faker->e164PhoneNumber;
			
			$collection['url']								= $faker->domainName;
			
			$collection['sortingValues']['topRestaurants']	= ($collection['sortingValues']['distance'] * $collection['sortingValues']['popularity']) + $collection['sortingValues']['ratingAverage'];
			
			return $collection;
		});
		
		return $collection->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
