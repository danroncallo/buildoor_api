<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'Administrador', 'description'=>'Administrador del sistema'],
            ['name' => 'Proveedor', 'description'=>'Proveedor'],
            ['name' => 'Cliente', 'description'=>'Cliente'],
        ];

        DB::table('roles')->insert($roles);
    }
}
