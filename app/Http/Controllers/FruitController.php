<?php

namespace App\Http\Controllers;

use App\Models\Fruit;
use App\Models\Favourite;
use Illuminate\Http\Request;
use DB;
use Mail;
// use App\Mail\NewAdminEmail;

class FruitController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$per_page = $request->per_page;
		$isFav = $request->is_fav;
		$res = Fruit::select('fruits.*', 'is_fav')->leftJoin('favourites', function ($join) {
			$join->on('favourites.fruit_id', '=', 'fruits.id')->where('favourites.user_id', '=', auth()->user()->id);
		})->orderBy('fruits.id');
		$search = $request->search;

		if (!is_null($search))
			$res = $res->where( function($query) use ($search) {
				$query->where('name', 'like', '%' . $search . '%')->orWhere('family', 'like', '%' . $search . '%');
			});

		if (!is_null($isFav))
			$res = $res->leftJoin('nutritions', 'nutritions.fruit_id', '=', 'fruits.id')
				->addSelect('carbohydrates', 'protein', 'fat', 'calories', 'sugar', 
					DB::raw('carbohydrates + protein + fat + calories + sugar as sum'))
				->where('is_fav', $isFav);
		
		$fruits = $res->paginate($per_page);		
		$response = [
			'current_page' => $fruits->currentPage(),
			'data' => $fruits->items(),
			'from' => $fruits->firstItem(),
        	'last_page' => $fruits->lastPage(),
			'first_page_url' => $fruits->url(1),
			'last_page_url' => $fruits->url($fruits->lastPage()),
			'next_page_url' => $fruits->nextPageUrl(),
			'prev_page_url' => $fruits->previousPageUrl(),
			'path' => $fruits->resolveCurrentPath(),
			'per_page' => $fruits->perPage(),
			'to' => $fruits->lastItem(),
			'total' => $fruits->total(),
			'exceedMaximumFavourites' => Favourite::where('user_id', auth()->user()->id)->where('is_fav', 1)->count() >= 10
		];
		return response($response);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$genus = $request->genus;
		$family = $request->family;
		$name = $request->name;
		$nutritions = ($request->nutritions);
		$order = $request->order;

		$rules = [
			'name' => ['required', 'unique:fruits', 'max:255'],
			'family' => ['required'],
			'genus' => ['required'],
			'nutritions' => ['required'],
			'order' => ['required']
		];

		$this->validate($request, $rules);

		$fruit = Fruit::create(compact("genus", "family", "nutritions", "order", "name"));
		$fruit->nutritions()->create($nutritions);
		$this->sendMailToAdmin($fruit->name. 'is added');
		return response($fruit);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Fruit  $fruit
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Fruit $fruit)
	{
		$rules = [
			'id' => ['required', 'exists:fruits']
		];
		$this->validate($request, $rules);

		$id = $request->id;
		$fruit = Fruit::find($id);
		$columns = ['name', 'family', 'order', 'nutritions', 'genus'];
		foreach ($columns as $column)
			if (!is_null($column))
				$fruit->$column = $request->$column;
		return Fruit::find($id);
	}
	
}