<?php

namespace Database\Seeders;

use App\Models\Salutation;
use Database\Factories\SalutationFactory;
use Illuminate\Database\Seeder;

class SalutationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Salutation::create(['bezeichnung' => 'Bitte auswählen']);
        Salutation::create(['bezeichnung' => 'Frau']);
        Salutation::create(['bezeichnung' => 'Eheleute']);
        Salutation::create(['bezeichnung' => 'Herrn u. Frau']);
        Salutation::create(['bezeichnung' => 'Frau u. Herrn']);
        Salutation::create(['bezeichnung' => 'Firma']);
        Salutation::create(['bezeichnung' => 'ETG']);
        Salutation::create(['bezeichnung' => 'Herrn']);
        Salutation::create(['bezeichnung' => 'WEG']);
        Salutation::create(['bezeichnung' => 'Erbengemeinschaft']);

    }
}
