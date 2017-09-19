<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $tables = [
        'locations',
        'categories',
        'uses',
        'products',
        'category_product',
        'product_uses',
        'users',
        'orders',
        'order_details',
        'warehouses',
        'stock',
        'shopping_carts',
        'roles',
        'portfolios',
        'images',
        'organizations',
        'organization_user',
        'equipment',
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(CategoriesTableSeeder::class);
         $this->call(UsesTableSeeder::class);
         $this->call(ProductsTableSeeder::class);
         $this->call(CountriesTableSeeder::class);
         $this->call(StatesTableSeeder::class);
         $this->call(RolesTableSeeder::class);
//         factory('App\User', 10)->create();
         factory('App\Organization', 10)->create();
         factory('App\Warehouse', 15)->create();
//         factory('App\Stock', 100)->create();
        $this->call(StocksTableSeeder::class);
        $this->call(ImagesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
//        factory('App\Image', 20)->create();
    }


}