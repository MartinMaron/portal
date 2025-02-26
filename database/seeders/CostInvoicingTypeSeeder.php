<?php

namespace Database\Seeders;

use App\Models\Costinvoicingtype;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CostinvoicingtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Costinvoicingtype::create(['id' => 'BE', 'caption' => 'Betriebskostenabrechnung']);
        Costinvoicingtype::create(['id' => 'HZ', 'caption' => 'Heizkostenabrechnung']);
        Costinvoicingtype::create(['id' => 'NO', 'caption' => 'geht in keine Abrechnung']);
        Costinvoicingtype::create(['id' => 'WA', 'caption' => 'Wasserabrechnung (Kalt und/oder  Warm)']);        
    }
}
