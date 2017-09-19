<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Cantera'],
            ['name' => 'Madera'],
            ['name' => 'Granito'],
            ['name' => 'Acero laminado'],
            ['name' => 'Porcelanato'],
        ];

        DB::table('categories')->insert($categories);
    }
}
