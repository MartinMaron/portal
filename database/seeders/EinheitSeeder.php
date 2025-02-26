<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EinheitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('einheits')->insert(["caption" => 'Quadratmeter',"shortname" => 'm²']);
        DB::table('einheits')->insert(["caption" => 'Cubikmeter',"shortname" => 'm³']);
        DB::table('einheits')->insert(["caption" => 'Personentage',"shortname" => 'm²']);
        DB::table('einheits')->insert(["caption" => 'Kilowattstunden',"shortname" => 'kWh']);
        DB::table('einheits')->insert(["caption" => 'Sondereinheiten',"shortname" => 'Son.']);
        DB::table('einheits')->insert(["caption" => 'Mieteigentumseinheiten',"shortname" => 'ME']);
        DB::table('einheits')->insert(["caption" => 'Wohneinheiten',"shortname" => 'WE']);
        DB::table('einheits')->insert(["caption" => 'Prozente',"shortname" => '%']);
        DB::table('einheits')->insert(["caption" => 'Liter',"shortname" => 'Ltr.']);
        DB::table('einheits')->insert(["caption" => 'GigaJoule',"shortname" => 'GJ']);
        DB::table('einheits')->insert(["caption" => 'Kilogramm',"shortname" => 'Kg']);
        DB::table('einheits')->insert(["caption" => 'Einheiten',"shortname" => 'Einh.']);
        DB::table('einheits')->insert(["caption" => 'Anzahl',"shortname" => 'Anz.']);
        DB::table('einheits')->insert(["caption" => 'Festkosten und Verbrauch',"shortname" => 'Son.']);
    }
}
