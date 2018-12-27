<?php

use Faker\Generator as Faker;

$factory->define(App\Operation::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 10),
        'shipper' => $faker->numberBetween($min = 1, $max = 108),
        'master_consignee' => $faker->numberBetween($min = 1, $max = 108),
        'house_consignee' => $faker->numberBetween($min = 1, $max = 108),
        'etd' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'eta' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'impo_expo' => $faker->randomElement($array = array ('IMPO','EXPO')),
        'pol' => $faker->word,
        'pod' => $faker->word,
        'destino' => $faker->word,
        'incoterm' => $faker->word,
        'booking' => $faker->swiftBicNumber,
        'custom_cutoff' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'vessel' => $faker->word,
        'o_f' => $faker->word,
        'c_invoice' => $faker->swiftBicNumber,
        'm_bl' => $faker->swiftBicNumber,
        'h_bl' => $faker->swiftBicNumber,
        'aa' => $faker->word,
    ];
});
