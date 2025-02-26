<?php

namespace Database\Seeders;

use App\Models\Costinvoicingiype;
use App\Models\Costtype;
use App\Models\Fueltype;
use App\Models\Salutation;
use App\Models\ZaehlerArt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            SalutationSeeder::class,
            EinheitSeeder::class,
            ZaehlerArtSeeder::class,
            UnitUsageTypeSeeder::class,
            CostinvoicingtypeSeeder::class,
            CosttypeSeeder::class,
            FueltypeSeeder::class,
            LageSeeder::class,
        ]);


    }
}
