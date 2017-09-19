<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            ['name' => 'Base', 'price'=>20],
            ['name' => 'Arena y triturados', 'price'=>25],
            ['name' => 'Bloques de cemento', 'price'=>30],
            ['name' => 'Concreto', 'price'=>40],
        ];

        DB::table('products')->insert($products);
    }
}
