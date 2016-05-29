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

$factory->define(CodeProject\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(CodeProject\Models\Client::class, function (Faker\Generator $faker) {

    $faker->addProvider(new Faker\Provider\pt_BR\Company($faker));
    $faker->addProvider(new CodeProject\Faker\Pessoa($faker));
    $faker->addProvider(new Faker\Provider\pt_BR\Address($faker));
    $faker->addProvider(new Faker\Provider\pt_BR\PhoneNumber($faker));

    return [
      'name' => $faker->company,
      'responsible' => trim($faker->name),
      'email' => $faker->email,
      'phone' => $faker->phoneNumber,
      'address' => $faker->address,
      'obs' => $faker->sentence,
    ];
});
