<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Fruit;
use App\Models\Nutrition;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * use Illuminate\Support\Str;

     */
    public function run()
    {
        // Admin
        DB::table('users')->insert([
            'id' => Str::uuid()->toString(),
            'firstname' => 'admin',
            'lastname' => '',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'is_admin' => true
        ]);
        
        // Fruit
        $json = file_get_contents('https://fruityvice.com/api/fruit/all');
        $fruits = json_decode($json);
  
        foreach ($fruits as $key => $value) {
            $fruit = Fruit::create([
                "genus" => $value->genus,
                "name" =>  $value->name,
                "family" =>  $value->family,
                "order" =>  $value->order,
            ]);
            // $nutritions = $fruit->nutritions()->create(json_decode(($value->nutritions)));
            $nutritions = $value->nutritions;
            Nutrition::create([
                "fruit_id" => $fruit->id,
                "carbohydrates" => $nutritions->carbohydrates,
                "protein"=> $nutritions->protein,
                "fat"=> $nutritions->fat,
                "calories"=> $nutritions->calories,
                "sugar"=> $nutritions->sugar

            ]);

        }
    }
}
