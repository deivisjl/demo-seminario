<?php

namespace App\Imports;

use App\Municipio;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MunicipioImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Municipio::create([
                'id' => $row[0],
                'nombre' => $row[1],
                'departamento_id' => $row[2]
            ]);
        }
    }
}
