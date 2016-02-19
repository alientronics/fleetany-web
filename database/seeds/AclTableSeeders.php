<?php

use Illuminate\Database\Seeder;
use Kodeine\Acl\Models\Eloquent\Role;
use App\User;
use Kodeine\Acl\Models\Eloquent\Permission;

class AclTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Rules
        $role = new Role();
        $roleAdmin = $role->create([
            'name' => 'Administrator',
            'slug' => 'administrator',
            'description' => 'Administrador geral do sistema'
            ]);
        
    	$permission = new Permission();
    	$permAdmin = $permission->create([
    	    'name'        => 'admin',
    	    'slug'        => [
    	        'create' => true,
    	        'view'   => true,
    	        'update' => true,
    	        'delete' => true
    	    ],
    	    'description' => 'Administra permissoes do administrador do sistema'
    	]);
    	
    	$roleAdmin->assignPermission('admin');

    	$user = User::first();
    	if ($user) {
    	    $user->assignRole($roleAdmin);
    	}
    	

    	$permission = new Permission();
    	$permExecutive = $permission->create([
    	    'name'        => 'not_admin',
    	    'slug'        => [
    	        'create' => true,
    	        'view'   => true,
    	        'update' => true,
    	        'delete' => false
    	    ],
    	    'description' => 'Administra permissoes das categorias de usuarios diferentes de administrador'
    	]);
    	
    	$role = new Role();
    	$roleExecutive = $role->create([
    	    'name' => 'Executive',
    	    'slug' => 'executive',
    	    'description' => 'Usuario da categoria "Executive" do sistema'
    	]);
    	
    	$roleExecutive->assignPermission('not_admin');
    	
    	
    	
    	$role = new Role();
    	$roleManager = $role->create([
    	    'name' => 'Manager',
    	    'slug' => 'manager',
    	    'description' => 'Usuario da categoria "Manager" do sistema'
    	]);
    	
    	$roleManager->assignPermission('not_admin');
    	
    	
    	
    	$role = new Role();
    	$roleOperational = $role->create([
    	    'name' => 'Operational',
    	    'slug' => 'operational',
    	    'description' => 'Usuario da categoria "Operational" do sistema'
    	]);
    	
    	$roleOperational->assignPermission('not_admin');
    	
    	
    	
    	$role = new Role();
    	$roleStaff = $role->create([
    	    'name' => 'Staff',
    	    'slug' => 'staff',
    	    'description' => 'Usuario da categoria "Staff" do sistema'
    	]);
    	
    	$roleStaff->assignPermission('not_admin');
    	



//     	Administrador
//         	Modelo Veículo
//         	Modelo Monitor
//         	Modelo Sensor
//         	Modelo Pneu
//     	Gestor
//         	Usuários (somente da empresa)
//         	Filiais (lista empresas)
//         	Frotas (grupo de veículos)
//     	Gerente
//         	Motorista
//         	Empresa
//         	Pressão Padrão (para empresa / modelo veículo)
//     	Comum
//     	   Perfil do Usuário
    	
    	   
    }
}
