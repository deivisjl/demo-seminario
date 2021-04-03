<?php

namespace App\Services\Region;

use Illuminate\Http\Request;

interface IRegionService
{
    public function guardar(Request $request);
    public function obtenerPorId($id);
    public function mostrarTodos(Request $request);
    public function actualizar(Request $request);
    public function eliminar($id);
}
