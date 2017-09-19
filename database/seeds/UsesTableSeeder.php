<?php

use Illuminate\Database\Seeder;

class UsesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uses = [
            ['name' => 'Recubrimientos'],
            ['name' => 'Molduras'],
            ['name' => 'Tabiques'],
            ['name' => 'Muebles'],
            ['name' => 'Aglutinante'],
            ['name' => 'Vigas'],
            ['name' => 'Cimientos'],
            ['name' => 'Estructura'],
            ['name' => 'Pilares'],
        ];

        DB::table('uses')->insert($uses);
    }
}
