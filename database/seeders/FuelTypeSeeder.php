<?php

namespace Database\Seeders;

use App\Models\Fueltype;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FueltypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fueltype::create(['id' => 'GS4', 'caption' => 'Gas', 'einheit_id' => 4, 'hasTank' => false]);
        Fueltype::create(['id' => 'OL9', 'caption' => 'Heizöl', 'einheit_id' => 9, 'hasTank' => true]);
        Fueltype::create(['id' => 'EC4', 'caption' => 'Fernwärme', 'einheit_id' => 4, 'hasTank' => false]);
        Fueltype::create(['id' => 'EG1', 'caption' => 'Pellets', 'einheit_id' => 11, 'hasTank' => true]);
        Fueltype::create(['id' => 'GS9', 'caption' => 'Flüssiggas', 'einheit_id' => 9, 'hasTank' => true]);
        Fueltype::create(['id' => 'STZ', 'caption' => 'Strom', 'einheit_id' => 4, 'hasTank' => false]);
    }
}
