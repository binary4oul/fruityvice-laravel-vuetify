<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $fruitId = $request->fruit_id;
        $isFav = $request->is_fav;
        $userId = auth()->user()->id;
        $favourite = Favourite::where('user_id', $userId)->where('fruit_id', $fruitId)->first();
        $exceedMaximumFavourites = $this->exceedMaximumFavourites();
        
        if((!is_null($favourite) && !$exceedMaximumFavourites) || ($exceedMaximumFavourites && !$isFav)){
            $favourite->is_fav = $isFav;
            $favourite->save();
            $favourite->exceedMaximumFavourites = $this->exceedMaximumFavourites();
            return response($favourite);
        }
        
        else if(is_null($favourite) && !$exceedMaximumFavourites) {
            $favourite = Favourite::create([
                'fruit_id' => $fruitId,
                'user_id' => $userId,
                'is_fav' => $isFav
            ]);
            $favourite->exceedMaximumFavourites = $this->exceedMaximumFavourites();

            return $favourite;
        }

        else
            return response(["message" => "Exceed maximum count of favourite fruits.", 'error' => 1, 'exceedMaximumFavourites' => $this->exceedMaximumFavourites()]);
    }

    private function exceedMaximumFavourites() {
        return Favourite::where('user_id', auth()->user()->id)->where('is_fav', 1)->count() >= 10;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Favourite  $favourite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favourite $favourite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favourite  $favourite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favourite $favourite)
    {
        //
    }
}
