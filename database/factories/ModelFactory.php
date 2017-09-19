<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'last_name' => $faker->lastName,
        'identification' => $faker->lastName,
        'phone_number' => $faker->phoneNumber,
        'cellphone' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'profession' => $faker->word,
        'address' => $faker->address,
        'logo_img_path' => $faker->image(),
        'status' => $faker->randomElement($array = array ('active', 'inactive')),
        'password' => $password ?: $password = bcrypt('123456'),
        'remember_token' => str_random(10),
        'city_id' => $faker->numberBetween($min = 1, $max = 32),
        'role_id' => $faker->numberBetween($min = 3, $max = 3)
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'last_name' => $faker->lastName,
        'identification' => $faker->lastName,
        'phone_number' => $faker->phoneNumber,
        'cellphone' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'profession' => $faker->jobTitle,
        'address' => $faker->address,
        'logo_img_path' => $faker->image(),
        'status' => $faker->randomElement($array = array ('active', 'inactive')),
        'password' => $password ?: $password = bcrypt('123456'),
        'remember_token' => str_random(10),
        'city_id' => $faker->numberBetween($min = 1, $max = 32),
        'role_id' => $faker->numberBetween($min = 3, $max = 3)
    ];
});

$factory->define(App\Organization::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->company,
        'NIT' => $faker->postcode
    ];
});

$factory->define(App\Warehouse::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->company,
        'organization_id' => $faker->numberBetween($min = 1, $max = 10)
    ];
});

$factory->define(App\Stock::class, function (Faker\Generator $faker) {

    return [
        'quantity' => $faker->numberBetween($min = 0, $max = 10),
        'product_id' => $faker->numberBetween($min = 1, $max = 4),
        'warehouse_id' => $faker->numberBetween($min = 1, $max = 15)
    ];
});

//$factory->define(App\Image::class, function (Faker\Generator $faker) {
//
//    return [
//        'full_path' => $faker->imageUrl($width = 640, $height = 480),
//        'path' => $faker->imageUrl($width = 640, $height = 480),
//        'product_id' => $faker->numberBetween($min = 1, $max = 4)
//    ];
//});
//
//$factory->define(App\Image::class, function (Faker\Generator $faker) {
//
//    return [
//        'full_path' => $faker->imageUrl($width = 800, $height = 600),
//        'path' => $faker->imageUrl($width = 640, $height = 480),
//        'product_id' => $faker->numberBetween($min = 1, $max = 4)
//    ];
//});

$factory->define(App\Image::class, function (Faker\Generator $faker) {

    return [
        'full_path' => $faker->imageUrl($width = 1080, $height = 480),
        'path' => $faker->imageUrl($width = 640, $height = 480),
        'product_id' => $faker->numberBetween($min = 1, $max = 4)
    ];
});

