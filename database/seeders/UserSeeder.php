<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Creación de un SuperUsuario que permita el acceso a la aplicación
        //desde el primer momento. La contraseña podrá ser cambiada posteriormente
        //en la aplicación.

        User::create([
            'name' => 'admin',
            'lastname' => 'admin',
            'dni' => '000000000',
            'email' => 'admin@admin.com',
            'phone' => '926926926',
            'password' => Hash::make('12345678'),
        ])->assignRole('Administrador');
    }
}
