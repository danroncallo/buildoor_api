<?php

use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = [
            ['original_name' => 'Color',
                'full_path' => 'http://api.ejsoluciones.com.ve/images/products/DefaultProduct.jpg',
                'path' => 'images/products/2017-06-22-04-15-38.color.jpg',
                'main_image' => true,
                'product_id'=>1],

            ['original_name' => 'Color',
                'full_path' => 'http://api.ejsoluciones.com.ve/images/products/DefaultProduct.jpg',
                'path' => 'images/products/2017-06-22-04-15-38.color.jpg',
                'main_image' => true,
                'product_id'=>2],

            ['original_name' => 'Color',
                'full_path' => 'http://api.ejsoluciones.com.ve/images/products/DefaultProduct.jpg',
                'path' => 'images/products/2017-06-22-04-15-38.color.jpg',
                'main_image' => true,
                'product_id'=>3],

            ['original_name' => 'Color',
                'full_path' => 'http://api.ejsoluciones.com.ve/images/products/DefaultProduct.jpg',
                'path' => 'images/products/2017-06-22-04-15-38.color.jpg',
                'main_image' => true,
                'product_id'=>4],
        ];

        DB::table('images')->insert($images);
    }
}
