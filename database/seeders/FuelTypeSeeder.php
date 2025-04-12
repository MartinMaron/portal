<?php

namespace Database\Seeders;

use App\Models\FuelType;
use Illuminate\Database\Seeder;

class FuelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FuelType::create(['id' => 'GS4', 'caption' => 'Gas', 'einheit_id' => 4, 'hasTank' => false]);
        FuelType::create(['id' => 'OL9', 'caption' => 'Heizöl', 'einheit_id' => 9, 'hasTank' => true]);
        FuelType::create(['id' => 'EC4', 'caption' => 'Fernwärme', 'einheit_id' => 4, 'hasTank' => false]);
        FuelType::create(['id' => 'EG1', 'caption' => 'Pellets', 'einheit_id' => 11, 'hasTank' => true]);
        FuelType::create(['id' => 'GS9', 'caption' => 'Flüssiggas', 'einheit_id' => 9, 'hasTank' => true]);
        FuelType::create(['id' => 'STZ', 'caption' => 'Strom', 'einheit_id' => 4, 'hasTank' => false]);
    }
}
