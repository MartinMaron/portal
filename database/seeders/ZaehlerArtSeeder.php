<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZaehlerArtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('zaehler_arten')->insert(["art" => 'KWZ',"caption" => 'Kaltwasserzähler',"einheit_id" => '2',"sort_reihenfolge" => '4']);
        DB::table('zaehler_arten')->insert(["art" => 'STZ',"caption" => 'Stromzähler',"einheit_id" => '4',"sort_reihenfolge" => '5']);
        DB::table('zaehler_arten')->insert(["art" => 'WWZ',"caption" => 'Warmwasserzähler',"einheit_id" => '2',"sort_reihenfolge" => '3']);
        DB::table('zaehler_arten')->insert(["art" => 'WMZ',"caption" => 'Wärmemengenzähler',"einheit_id" => '4',"sort_reihenfolge" => '1']);
        DB::table('zaehler_arten')->insert(["art" => 'HKV',"caption" => 'Heizkostenverteiler',"einheit_id" => '12',"sort_reihenfolge" => '2']);
        DB::table('zaehler_arten')->insert(["art" => 'GAS',"caption" => 'Gaszähler',"einheit_id" => '2',"sort_reihenfolge" => '6']);
        DB::table('zaehler_arten')->insert(["art" => 'ZUB',"caption" => 'Zubehör',"einheit_id" => '5',"sort_reihenfolge" => '7']);
        DB::table('zaehler_arten')->insert(["art" => 'RWM',"caption" => 'Rauchwarnmelder',"einheit_id" => '5',"sort_reihenfolge" => '8']);
    }
}
