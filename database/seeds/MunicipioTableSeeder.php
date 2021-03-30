<?php

use Illuminate\Database\Seeder;
use App\Imports\MunicipioImport;
use Maatwebsite\Excel\Facades\Excel;

class MunicipioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $municipios = Excel::import(new MunicipioImport, 'database/seeds/Imports/Municipios.xlsx');
    }
}
