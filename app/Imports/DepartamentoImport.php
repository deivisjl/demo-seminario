<?php

namespace App\Imports;

use App\Departamento;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DepartamentoImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Departamento::create([
                'id' => $row[0],
                'nombre' => $row[1],
                'region_id' => $row[2]
            ]);
        }
    }
}
