<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = [
            ['name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt(1234),
                'country_id' => 1,
                'role_id' => 1]];
        DB::table('users')->insert($user1);
        
        $user2 = [['name' => 'Elio',
                'last_name' => 'Acosta',
                'email'=>'ea@gmail.com',
                'identification'=> '345678',
                'phone' => '12345876',
                'country_id' => 1,
                'status' => 'active',
                'postal_code' => '1212',
                'profession' => 'Ingeniero',
                'role_id' => 3,
                'password'=>bcrypt(123456)]];
        DB::table('users')->insert($user2);
        
        $user3 = [['name' => 'Jessica',
              'last_name' => 'Perez',
              'email'=>'correo@correo.com',
              'identification'=> '345678',
              'phone' => '12345876',
              'country_id' => 1,
              'status' => 'active',
              'postal_code' => '1212',
              'profession' => 'Ingeniero',
              'role_id' => 3,
              'password'=>bcrypt(1234)]];
        DB::table('users')->insert($user3);

    }
}
