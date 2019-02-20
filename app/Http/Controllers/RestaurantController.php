<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cookie;

class RestaurantController extends Controller
{
	public $restaurants = [];
	
	public function __construct(){
		$this->restaurants = json_decode(\File::get(database_path('data/restaurants.json')), true)['restaurants'];
	}
	
    /**
     * Custom comparer for Laravel Collection objects that enables sorting collections by multiple criteria.
	 * Credit: https://stackoverflow.com/a/33304416/2560062
     *
     * @return \Illuminate\Http\Response
     */
	private function makeComparer($criteria){
		$comparer = function ($first, $second) use ($criteria) {
			foreach ($criteria as $key => $orderType) {
				$orderType = strtolower($orderType);
				
				if ($first['sortingValues'][$key] < $second['sortingValues'][$key])
					return $orderType === "asc" ? -1 : 1;
				
				else if ($first['sortingValues'][$key] > $second['sortingValues'][$key])
					return $orderType === "asc" ? 1 : -1;
			}

			return 0;
		};
		
		return $comparer;
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		// User favorites are stored in cookie, since no database is used in this project.
		if(is_null(Cookie::get('favoritedRestaurants')))
			setcookie('favoritedRestaurants', '');
		
        $collection = collect($this->restaurants);
		
		$favoritedRestaurants = explode(";", Cookie::get('favoritedRestaurants'));
		
		$collection = $collection->map(function($collection) use ($favoritedRestaurants){
			$collection['image']							= "images/featured".((strlen($collection['name']) % 4) + 1).".jpg"; // random images assigned

			$collection['sortingValues']['status']			= ($collection['status'] == 'open') ? 3 : (($collection['status'] == 'order ahead') ? 2 : 1); // status numeralized
			
			$collection['sortingValues']['isFavorited']		= (in_array($collection['name'], $favoritedRestaurants)) ? 1 : 0; // favorite status
									
			$collection['sortingValues']['topRestaurants']	= ($collection['sortingValues']['distance'] * $collection['sortingValues']['popularity']) + $collection['sortingValues']['ratingAverage'];
			
			return $collection;
		});
		
		$sort_criteria = ['isFavorited' => 'desc', 'status' => 'desc'];
		
		$sortby = ($request->has('sortby')) ? $request->sortby : 'best_match';
		
		switch($sortby){
			case 'newest':
				$sort_criteria['newest'] = 'desc';
				
				break;
			case 'rating_average':
				$sort_criteria['ratingAverage'] = 'desc';
				
				break;
			case 'distance':
				$sort_criteria['distance'] = 'asc';
				
				break;
			case 'popularity':
				$sort_criteria['popularity'] = 'desc';
				
				break;
			case 'average_product_price':
				$sort_criteria['averageProductPrice'] = 'asc';
				
				break;
			case 'delivery_costs':
				$sort_criteria['deliveryCosts'] = 'asc';
				
				break;
			case 'minimum_costs':
				$sort_criteria['minCost'] = 'asc';
				
				break;
			case 'top_restaurants':
				$sort_criteria['topRestaurants'] = 'desc';
				
				break;
		}
		
		$search = ($request->has('search')) ? $request->search : '';
		
		if($search)
			return $collection->filter(function ($collection) use ($search) {
				return false !== stristr($collection['name'], $search);
			})->sort($this->makeComparer($sort_criteria))->values()->all();
			
		else
			return $collection->sort($this->makeComparer($sort_criteria))->values()->all();
    }

    /**
     * Store user favorites into the cookie.
     *
     * @return \Illuminate\Http\Response
     */
    public function favorite(Request $request)
    {
        $collection = collect($this->restaurants);
				
		try{
			$validatedData = $request->validate([
				'restaurant' => 'required|array'
			]);
			
			$favoritedRestaurants = explode(";", Cookie::get('favoritedRestaurants'));
			
			if(!isset($request->restaurant['name']) || is_null($collection->where('name', $request->restaurant['name'])))
				return response()->json(['error' => "Faulty data!"], 403); 
			
			if(in_array($request->restaurant['name'], $favoritedRestaurants))
				return response()->json(['error' => "Already favourite!"], 403); 
			
			$favoritedRestaurants[] = $request->restaurant['name'];
		
			setcookie('favoritedRestaurants', join(";", $favoritedRestaurants));
			
			return response()->json(['success' => $request->restaurant['name']." added to your favorites!"], 200);
		} catch(\Exception $e){
			return response()->json(['error' => $e->getMessage()], 403); 
		}
    }
	
    /**
     * Delete user favorites from the cookie.
     *
     * @return \Illuminate\Http\Response
     */
    public function unfavorite(Request $request)
    {
        $collection = collect($this->restaurants);
		
		try{
			$validatedData = $request->validate([
				'restaurant' => 'required|array'
			]);
			
			$favoritedRestaurants = explode(";", Cookie::get('favoritedRestaurants'));
			
			if(!isset($request->restaurant['name']) || is_null($collection->where('name', $request->restaurant['name'])))
				return response()->json(['error' => "Faulty data!"], 403); 
			
			if(!in_array($request->restaurant['name'], $favoritedRestaurants))
				return response()->json(['error' => "Not a favourite!"], 403); 
			
			$key = array_search($request->restaurant['name'], $favoritedRestaurants);
			
			unset($favoritedRestaurants[$key]);
		
			setcookie('favoritedRestaurants', join(";", $favoritedRestaurants));
			
			return response()->json(['success' => $request->restaurant['name']." removed from your favorites!"], 200);
		} catch(\Exception $e){
			return response()->json(['error' => $e->getMessage()], 403); 
		}
    }
}
