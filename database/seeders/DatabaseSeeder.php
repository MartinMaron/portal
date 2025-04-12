<?php

namespace Database\Seeders;

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
            CostInvoicingTypeSeeder::class,
            CostTypeSeeder::class,
            FuelTypeSeeder::class,
            LageSeeder::class,
        ]);

    }
}
