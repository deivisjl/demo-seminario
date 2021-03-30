<?php

use Illuminate\Database\Seeder;
use App\Imports\DepartamentoImport;
use Maatwebsite\Excel\Facades\Excel;

class DepartamentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departamentos = Excel::import(new DepartamentoImport, 'database/seeds/Imports/departamentos.xlsx');
    }
}
