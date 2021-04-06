<?php

use App\ActividadEconomica;
use Illuminate\Database\Seeder;

class ActividadEconomicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ActividadEconomica::insert([
            ['nombre'=>'Comercios'],
            ['nombre'=>'Colegios'],
            ['nombre'=>'Telefonía'],
            ['nombre'=>'Escuelas e Institutos'],
            ['nombre'=>'Bancos'],
            ['nombre'=>'Energía Eléctrica'],
            ['nombre'=>'Construcciones/Inmobiliarias'],
            ['nombre'=>'Tarjetas de Crédito'],
            ['nombre'=>'Combustible'],
            ['nombre'=>'Servicio de Agua'],
            ['nombre'=>'Tiempos compartidos'],
            ['nombre'=>'Cafeterias y Otros'],
            ['nombre'=>'Hotelería'],
            ['nombre'=>'Otros '],
            ['nombre'=>'Transporte '],
            ['nombre'=>'Prestamos '],
            ['nombre'=>'Aseguradoras'],
            ['nombre'=>'Servicio de Cable'],
            ['nombre'=>'Distribuidora de Gas'],
            ['nombre'=>'Servicio de Internet'],
            ['nombre'=>'Instituciones'],
            ['nombre'=>'Canasta Básica'],
            ['nombre'=>'Hospitales'],
            ['nombre'=>'Casas de empeño'],
            ['nombre'=>'Taller'],
        ]);
    }
}
