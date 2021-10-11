<?php

use Illuminate\Database\Seeder;

class QuantityOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\QuantityOption::insert([
            'name' => 'Kg',
            'created_at' => date("Y-m-d H:i:s")
        ]);
    }
}
