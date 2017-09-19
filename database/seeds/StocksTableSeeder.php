<?php

use App\Stock;
use Illuminate\Database\Seeder;

class StocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i<=4; $i++){
            $stock = new Stock([
                'quantity' => 0,
                'product_id' => $i
            ]);
            $stock->save();
        }
    }
}
