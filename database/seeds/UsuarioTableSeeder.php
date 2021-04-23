<?php

use App\Rol;
use App\User;
use Illuminate\Database\Seeder;

class UsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol = Rol::create(['nombre' => 'Administrador']);
        $rol = Rol::create(['nombre' => 'Analista']);

        User::create([
            'nombres' => 'Admin',
            'apellidos' => 'Administrador',
            'dpi' => '2203569250101',
            'telefono' => '12345678',
            'direccion' => 'Ciudad',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345'),
            'rol_id' => $rol->id
        ]);
    }
}
