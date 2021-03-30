<?php

use App\Region;
use App\Municipio;
use App\Departamento;
use Illuminate\Database\Seeder;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Region::insert([
            ['nombre' => 'Metropolitana'],
            ['nombre' => 'Verapaz'],
            ['nombre' => 'Nororiente'],
            ['nombre' => 'Suroriente'],
            ['nombre' => 'Central'],
            ['nombre' => 'Suroccidente'],
            ['nombre' => 'Noroccidente'],
            ['nombre' => 'Peten']
        ]);
    }
}
