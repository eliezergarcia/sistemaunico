<?php

use App\Operation;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class OperationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Operation::class, 50)->create();
    }
}
