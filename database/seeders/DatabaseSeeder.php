<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //DML Permito la generación en la BBDD via Seed de los roles y permisos generados
        //en RolePermissionSeeder.
        $this->call(RolePermissionSeeder::class);

        //DML Permito la generación en la BBDD via Seed del usuario que tomaré como SuperUser
        $this->call(UserSeeder::class);
    }
}
