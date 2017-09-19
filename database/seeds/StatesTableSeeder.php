<?php

use App\Country;
use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = Country::where('name', 'Colombia')->first();
        $states = [
            ['name' => 'Amazonas', 'country_id' => $country->id],
            ['name' => 'Antioquia', 'country_id' => $country->id],
            ['name' => 'Arauca', 'country_id' => $country->id],
            ['name' => 'Atlántico', 'country_id' => $country->id],
            ['name' => 'Bolívar', 'country_id' => $country->id],
            ['name' => 'Boyacá', 'country_id' => $country->id],
            ['name' => 'Caldas', 'country_id' => $country->id],
            ['name' => 'Caquetá', 'country_id' => $country->id],
            ['name' => 'Casanare', 'country_id' => $country->id],
            ['name' => 'Cauca', 'country_id' => $country->id],
            ['name' => 'Cesar', 'country_id' => $country->id],
            ['name' => 'Chocó', 'country_id' => $country->id],
            ['name' => 'Córdoba', 'country_id' => $country->id],
            ['name' => 'Cundinamarca', 'country_id' => $country->id],
            ['name' => 'Guainía', 'country_id' => $country->id],
            ['name' => 'Guaviare', 'country_id' => $country->id],
            ['name' => 'Huila', 'country_id' => $country->id],
            ['name' => 'La Guajira', 'country_id' => $country->id],
            ['name' => 'Magdalena', 'country_id' => $country->id],
            ['name' => 'Meta', 'country_id' => $country->id],
            ['name' => 'Nariño', 'country_id' => $country->id],
            ['name' => 'Norte de Santander', 'country_id' => $country->id],
            ['name' => 'Putumayo', 'country_id' => $country->id],
            ['name' => 'Quindio', 'country_id' => $country->id],
            ['name' => 'Risaralda', 'country_id' => $country->id],
            ['name' => 'San Andres y Providencia', 'country_id' => $country->id],
            ['name' => 'Santander', 'country_id' => $country->id],
            ['name' => 'Sucre', 'country_id' => $country->id],
            ['name' => 'Tolima', 'country_id' => $country->id],
            ['name' => 'Valle del Cauca', 'country_id' => $country->id],
            ['name' => 'Vaupés', 'country_id' => $country->id],
            ['name' => 'Vichada', 'country_id' => $country->id],
        ];
        DB::table('states')->insert($states);
    }
}
