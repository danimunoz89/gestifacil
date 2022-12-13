<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Creo los roles de usuario de Gestifacil y
         * los permisos de acceso a las distintas partes de la aplicación.
         * 
         * Genero los distintos permisos que validarán el acceso (o no) a los distintos
         * lugares de la aplicación
         * 
         * Administrador => Todo los permisos
         * Usuario => Permisos limitados
         */

        $admin = Role::create(['name' => 'Administrador']);
        $user = Role::create(['name' => 'Usuario']);

        Permission::create(['name' => 'ver_rutero']);
        Permission::create(['name' => 'editar_dia']);
        Permission::create(['name' => 'listar_usuarios']);
        Permission::create(['name' => 'crear_usuarios']);
        Permission::create(['name' => 'editar_usuarios']);
        Permission::create(['name' => 'eliminar_usuarios']);
        Permission::create(['name' => 'listar_clientes']);
        Permission::create(['name' => 'crear_clientes']);
        Permission::create(['name' => 'editar_clientes']);
        Permission::create(['name' => 'eliminar_clientes']);
        Permission::create(['name' => 'listar_categorias']);
        Permission::create(['name' => 'crear_categorias']);
        Permission::create(['name' => 'editar_categorias']);
        Permission::create(['name' => 'eliminarcategorias']);
        Permission::create(['name' => 'listar_productos']);
        Permission::create(['name' => 'crear_productos']);
        Permission::create(['name' => 'editar_productos']);
        Permission::create(['name' => 'eliminar_productos']);
        Permission::create(['name' => 'listar_pedidos']);
        Permission::create(['name' => 'crear_pedidos']);
        Permission::create(['name' => 'editar_notapedidos']);
        Permission::create(['name' => 'eliminar_pedidos']);
        Permission::create(['name' => 'pdf_pedidos']);
        Permission::create(['name' => 'mapa_web']);

        //Vinculo roles con permisos

        $admin->syncPermissions([
            'ver_rutero',
            'editar_dia',
            'listar_usuarios',
            'crear_usuarios',
            'editar_usuarios',
            'eliminar_usuarios',
            'listar_clientes',
            'crear_clientes',
            'editar_clientes',
            'eliminar_clientes',
            'listar_categorias',
            'crear_categorias',
            'editar_categorias',
            'eliminarcategorias',
            'listar_productos',
            'crear_productos',
            'editar_productos',
            'eliminar_productos',
            'listar_pedidos',
            'crear_pedidos',
            'editar_notapedidos',
            'eliminar_pedidos',
            'pdf_pedidos',
            'mapa_web',
        ]);

        $user->syncPermissions([
            'ver_rutero',
            'editar_dia',
            'listar_clientes',
            'crear_clientes',
            'editar_clientes',
            'listar_productos',
            'listar_pedidos',
            'crear_pedidos',
            'editar_notapedidos',
            'pdf_pedidos',
            'mapa_web',
        ]);
    }
}
