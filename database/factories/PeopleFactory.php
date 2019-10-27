<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\People;
use Faker\Generator as Faker;

$factory->define(People::class, function (Faker $faker) {
    $fullName = $faker->firstName . ' ' . $faker->lastName;
    return [
        'name' => $fullName,
        'data' => json_encode([
            "name" => $fullName,
			"height" => $faker->numberBetween(50, 200),
			"mass" => $faker->numberBetween(50, 200),
			"hair_color" => $faker->colorName,
			"skin_color" => $faker->colorName,
			"eye_color" => $faker->colorName,
			"birth_year" => "19BBY",
			"gender" => "male",
			"homeworld" => "https://swapi.co/api/planets/1/",
			"films" => [
				"https://swapi.co/api/films/2/",
				"https://swapi.co/api/films/6/",
				"https://swapi.co/api/films/3/",
				"https://swapi.co/api/films/1/",
				"https://swapi.co/api/films/7/"
			],
			"species" => [
				"https://swapi.co/api/species/1/"
			],
			"vehicles" => [
				"https://swapi.co/api/vehicles/14/",
				"https://swapi.co/api/vehicles/30/"
			],
			"starships" => [
				"https://swapi.co/api/starships/12/",
				"https://swapi.co/api/starships/22/"
			],
			"created" => "2014-12-09T13:50:51.644000Z",
			"edited" => "2014-12-20T21:17:56.891000Z",
            "url" => "https://swapi.co/api/people/1/"
        ]),
    ];
});
