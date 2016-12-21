<?php

use Illuminate\Database\Seeder;
use Kodeine\Acl\Models\Eloquent\Role;
use App\Entities\User;
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
        $roleAdmin = Role::create([
            'name' => 'Administrator',
            'slug' => 'administrator',
            'description' => 'Administrador geral do sistema'
            ]);
        
        $roleExecutive = Role::create([
            'name' => 'Executive',
            'slug' => 'executive',
            'description' => 'Usuario da categoria "Executive" do sistema'
        ]);

        $roleManager = Role::create([
            'name' => 'Manager',
            'slug' => 'manager',
            'description' => 'Usuario da categoria "Manager" do sistema'
        ]);
         
        $roleOperational = Role::create([
            'name' => 'Operational',
            'slug' => 'operational',
            'description' => 'Usuario da categoria "Operational" do sistema'
        ]);
        
        $roleStaff = Role::create([
            'name' => 'Staff',
            'slug' => 'staff',
            'description' => 'Usuario da categoria "Staff" do sistema'
        ]);
         

        //Vehicle
        //Permissions
        $permVehicleStaff = Permission::create([
            'name'        => 'vehicle',
            'slug'        => [
                'create' => false,
                'view'   => false,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do vehicle para o nivel staff de usuario'
        ]);
        
        $permVehicleOperational = Permission::create([
            'name'        => 'vehicle.operational',
            'slug'        => [],
            'inherit_id' => $permVehicleStaff->getKey(),
            'description' => 'Administra permissoes do vehicle para o nivel operational de usuario'
        ]);
        
        $permVehicleManager = Permission::create([
            'name'        => 'vehicle.manager',
            'slug'        => [],
            'inherit_id' => $permVehicleOperational->getKey(),
            'description' => 'Administra permissoes do vehicle para o nivel manager de usuario'
        ]);
        
        $permVehicleExecutive = Permission::create([
            'name'        => 'vehicle.executive',
            'slug'        => [],
            'inherit_id' => $permVehicleManager->getKey(),
            'description' => 'Administra permissoes do vehicle para o nivel executive de usuario'
        ]);
        
        $permVehicleAdmin = Permission::create([
            'name'        => 'vehicle.admin',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => true,
                'delete' => true
            ],
            'inherit_id' => $permVehicleExecutive->getKey(),
            'description' => 'Administra permissoes do vehicle para o nivel admin de usuario'
        ]);
        
        
        //Assign permissions to rules
        $roleStaff->assignPermission($permVehicleStaff);
        $roleOperational->assignPermission($permVehicleOperational);
        $roleManager->assignPermission($permVehicleManager);
        $roleExecutive->assignPermission($permVehicleExecutive);
        $roleAdmin->assignPermission($permVehicleAdmin);


        //Contact
        //Permissions
        $permContactStaff = Permission::create([
            'name'        => 'contact',
            'slug'        => [
                'create' => false,
                'view'   => false,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do contact para o nivel staff de usuario'
        ]);
        
        $permContactOperational = Permission::create([
            'name'        => 'contact.operational',
            'slug'        => [],
            'inherit_id' => $permContactStaff->getKey(),
            'description' => 'Administra permissoes do contact para o nivel operational de usuario'
        ]);
        
        $permContactManager = Permission::create([
            'name'        => 'contact.manager',
            'slug'        => [],
            'inherit_id' => $permContactOperational->getKey(),
            'description' => 'Administra permissoes do contact para o nivel manager de usuario'
        ]);
        
        $permContactExecutive = Permission::create([
            'name'        => 'contact.executive',
            'slug'        => [],
            'inherit_id' => $permContactManager->getKey(),
            'description' => 'Administra permissoes do contact para o nivel executive de usuario'
        ]);
        
        $permContactAdmin = Permission::create([
            'name'        => 'contact.admin',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => true,
                'delete' => true
            ],
            'inherit_id' => $permContactExecutive->getKey(),
            'description' => 'Administra permissoes do contact para o nivel admin de usuario'
        ]);
        
        
        //Assign permissions to rules
        $roleStaff->assignPermission($permContactStaff);
        $roleOperational->assignPermission($permContactOperational);
        $roleManager->assignPermission($permContactManager);
        $roleExecutive->assignPermission($permContactExecutive);
        $roleAdmin->assignPermission($permContactAdmin);


        //Trip
        //Permissions
        $permTripStaff = Permission::create([
            'name'        => 'trip',
            'slug'        => [
                'create' => false,
                'view'   => false,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do trip para o nivel staff de usuario'
        ]);
        
        $permTripOperational = Permission::create([
            'name'        => 'trip.operational',
            'slug'        => [],
            'inherit_id' => $permTripStaff->getKey(),
            'description' => 'Administra permissoes do trip para o nivel operational de usuario'
        ]);
        
        $permTripManager = Permission::create([
            'name'        => 'trip.manager',
            'slug'        => [],
            'inherit_id' => $permTripOperational->getKey(),
            'description' => 'Administra permissoes do trip para o nivel manager de usuario'
        ]);
        
        $permTripExecutive = Permission::create([
            'name'        => 'trip.executive',
            'slug'        => [],
            'inherit_id' => $permTripManager->getKey(),
            'description' => 'Administra permissoes do trip para o nivel executive de usuario'
        ]);
        
        $permTripAdmin = Permission::create([
            'name'        => 'trip.admin',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => true,
                'delete' => true
            ],
            'inherit_id' => $permTripExecutive->getKey(),
            'description' => 'Administra permissoes do trip para o nivel admin de usuario'
        ]);
        
        
        //Assign permissions to rules
        $roleStaff->assignPermission($permTripStaff);
        $roleOperational->assignPermission($permTripOperational);
        $roleManager->assignPermission($permTripManager);
        $roleExecutive->assignPermission($permTripExecutive);
        $roleAdmin->assignPermission($permTripAdmin);
        

        //Part
        //Permissions
        $permPartStaff = Permission::create([
            'name'        => 'part',
            'slug'        => [
                'create' => false,
                'view'   => false,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do part para o nivel staff de usuario'
        ]);
        
        $permPartOperational = Permission::create([
            'name'        => 'part.operational',
            'slug'        => [],
            'inherit_id' => $permPartStaff->getKey(),
            'description' => 'Administra permissoes do part para o nivel operational de usuario'
        ]);
        
        $permPartManager = Permission::create([
            'name'        => 'part.manager',
            'slug'        => [],
            'inherit_id' => $permPartOperational->getKey(),
            'description' => 'Administra permissoes do part para o nivel manager de usuario'
        ]);
        
        $permPartExecutive = Permission::create([
            'name'        => 'part.executive',
            'slug'        => [],
            'inherit_id' => $permPartManager->getKey(),
            'description' => 'Administra permissoes do part para o nivel executive de usuario'
        ]);
        
        $permPartAdmin = Permission::create([
            'name'        => 'part.admin',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => true,
                'delete' => true
            ],
            'inherit_id' => $permPartExecutive->getKey(),
            'description' => 'Administra permissoes do part para o nivel admin de usuario'
        ]);
        
        
        //Assign permissions to rules
        $roleStaff->assignPermission($permPartStaff);
        $roleOperational->assignPermission($permPartOperational);
        $roleManager->assignPermission($permPartManager);
        $roleExecutive->assignPermission($permPartExecutive);
        $roleAdmin->assignPermission($permPartAdmin);
        
        
        //Entry
        //Permissions
        $permEntryStaff = Permission::create([
            'name'        => 'entry',
            'slug'        => [
                'create' => false,
                'view'   => false,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do entry para o nivel staff de usuario'
        ]);
        
        $permEntryOperational = Permission::create([
            'name'        => 'entry.operational',
            'slug'        => [],
            'inherit_id' => $permEntryStaff->getKey(),
            'description' => 'Administra permissoes do entry para o nivel operational de usuario'
        ]);
        
        $permEntryManager = Permission::create([
            'name'        => 'entry.manager',
            'slug'        => [],
            'inherit_id' => $permEntryOperational->getKey(),
            'description' => 'Administra permissoes do entry para o nivel manager de usuario'
        ]);
        
        $permEntryExecutive = Permission::create([
            'name'        => 'entry.executive',
            'slug'        => [],
            'inherit_id' => $permEntryManager->getKey(),
            'description' => 'Administra permissoes do entry para o nivel executive de usuario'
        ]);
        
        $permEntryAdmin = Permission::create([
            'name'        => 'entry.admin',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => true,
                'delete' => true
            ],
            'inherit_id' => $permEntryExecutive->getKey(),
            'description' => 'Administra permissoes do entry para o nivel admin de usuario'
        ]);
        
        
        //Assign permissions to rules
        $roleStaff->assignPermission($permEntryStaff);
        $roleOperational->assignPermission($permEntryOperational);
        $roleManager->assignPermission($permEntryManager);
        $roleExecutive->assignPermission($permEntryExecutive);
        $roleAdmin->assignPermission($permEntryAdmin);
        
        
        //Model
        //Permissions
        $permModelStaff = Permission::create([
            'name'        => 'model',
            'slug'        => [
                'create' => false,
                'view'   => false,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do model para o nivel staff de usuario'
        ]);
        
        $permModelOperational = Permission::create([
            'name'        => 'model.operational',
            'slug'        => [],
            'inherit_id' => $permModelStaff->getKey(),
            'description' => 'Administra permissoes do model para o nivel operational de usuario'
        ]);
        
        $permModelManager = Permission::create([
            'name'        => 'model.manager',
            'slug'        => [],
            'inherit_id' => $permModelOperational->getKey(),
            'description' => 'Administra permissoes do model para o nivel manager de usuario'
        ]);
        
        $permModelExecutive = Permission::create([
            'name'        => 'model.executive',
            'slug'        => [],
            'inherit_id' => $permModelManager->getKey(),
            'description' => 'Administra permissoes do model para o nivel executive de usuario'
        ]);
        
        $permModelAdmin = Permission::create([
            'name'        => 'model.admin',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => true,
                'delete' => true
            ],
            'inherit_id' => $permModelExecutive->getKey(),
            'description' => 'Administra permissoes do model para o nivel admin de usuario'
        ]);
        
        
        //Assign permissions to rules
        $roleStaff->assignPermission($permModelStaff);
        $roleOperational->assignPermission($permModelOperational);
        $roleManager->assignPermission($permModelManager);
        $roleExecutive->assignPermission($permModelExecutive);
        $roleAdmin->assignPermission($permModelAdmin);
        
        //Attribute
        //Permissions
        $permAttributeStaff = Permission::create([
            'name'        => 'attribute',
            'slug'        => [
                'create' => false,
                'view'   => false,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do attribute para o nivel staff de usuario'
        ]);
        
        $permAttributeOperational = Permission::create([
            'name'        => 'attribute.operational',
            'slug'        => [],
            'inherit_id' => $permAttributeStaff->getKey(),
            'description' => 'Administra permissoes do attribute para o nivel operational de usuario'
        ]);
        
        $permAttributeManager = Permission::create([
            'name'        => 'attribute.manager',
            'slug'        => [],
            'inherit_id' => $permAttributeOperational->getKey(),
            'description' => 'Administra permissoes do attribute para o nivel manager de usuario'
        ]);
        
        $permAttributeExecutive = Permission::create([
            'name'        => 'attribute.executive',
            'slug'        => [],
            'inherit_id' => $permAttributeManager->getKey(),
            'description' => 'Administra permissoes do attribute para o nivel executive de usuario'
        ]);
        
        $permAttributeAdmin = Permission::create([
            'name'        => 'attribute.admin',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => true,
                'delete' => true
            ],
            'inherit_id' => $permAttributeExecutive->getKey(),
            'description' => 'Administra permissoes do attribute para o nivel admin de usuario'
        ]);
        
        
        //Assign permissions to rules
        $roleStaff->assignPermission($permAttributeStaff);
        $roleOperational->assignPermission($permAttributeOperational);
        $roleManager->assignPermission($permAttributeManager);
        $roleExecutive->assignPermission($permAttributeExecutive);
        $roleAdmin->assignPermission($permAttributeAdmin);
        
        //Report
        //Permissions
        $permReportStaff = Permission::create([
            'name'        => 'report',
            'slug'        => [
                'create' => false,
                'view'   => false,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do report para o nivel staff de usuario'
        ]);
        
        $permReportOperational = Permission::create([
            'name'        => 'report.operational',
            'slug'        => [],
            'inherit_id' => $permReportStaff->getKey(),
            'description' => 'Administra permissoes do report para o nivel operational de usuario'
        ]);
        
        $permReportManager = Permission::create([
            'name'        => 'report.manager',
            'slug'        => [],
            'inherit_id' => $permReportOperational->getKey(),
            'description' => 'Administra permissoes do report para o nivel manager de usuario'
        ]);
        
        $permReportExecutive = Permission::create([
            'name'        => 'report.executive',
            'slug'        => [],
            'inherit_id' => $permReportManager->getKey(),
            'description' => 'Administra permissoes do report para o nivel executive de usuario'
        ]);
        
        $permReportAdmin = Permission::create([
            'name'        => 'report.admin',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => true,
                'delete' => true
            ],
            'inherit_id' => $permReportExecutive->getKey(),
            'description' => 'Administra permissoes do report para o nivel admin de usuario'
        ]);
        
        
        //Assign permissions to rules
        $roleStaff->assignPermission($permReportStaff);
        $roleOperational->assignPermission($permReportOperational);
        $roleManager->assignPermission($permReportManager);
        $roleExecutive->assignPermission($permReportExecutive);
        $roleAdmin->assignPermission($permReportAdmin);
        
        
        //Role
        //Permissions
        $permRoleStaff = Permission::create([
            'name'        => 'role',
            'slug'        => [
                'create' => false,
                'view'   => false,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do role para o nivel staff de usuario'
        ]);
        
        $permRoleOperational = Permission::create([
            'name'        => 'role.operational',
            'slug'        => [],
            'inherit_id' => $permRoleStaff->getKey(),
            'description' => 'Administra permissoes do role para o nivel operational de usuario'
        ]);
        
        $permRoleManager = Permission::create([
            'name'        => 'role.manager',
            'slug'        => [],
            'inherit_id' => $permRoleOperational->getKey(),
            'description' => 'Administra permissoes do role para o nivel manager de usuario'
        ]);
        
        $permRoleExecutive = Permission::create([
            'name'        => 'role.executive',
            'slug'        => [],
            'inherit_id' => $permRoleManager->getKey(),
            'description' => 'Administra permissoes do role para o nivel executive de usuario'
        ]);
        
        $permRoleAdmin = Permission::create([
            'name'        => 'role.admin',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => true,
                'delete' => true
            ],
            'inherit_id' => $permRoleExecutive->getKey(),
            'description' => 'Administra permissoes do role para o nivel admin de usuario'
        ]);
        
        
        //Assign permissions to rules
        $roleStaff->assignPermission($permRoleStaff);
        $roleOperational->assignPermission($permRoleOperational);
        $roleManager->assignPermission($permRoleManager);
        $roleExecutive->assignPermission($permRoleExecutive);
        $roleAdmin->assignPermission($permRoleAdmin);
        

        //Type
        //Permissions
        $permTypeStaff = Permission::create([
            'name'        => 'type',
            'slug'        => [
                'create' => false,
                'view'   => false,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do type para o nivel staff de usuario'
        ]);
        
        $permTypeOperational = Permission::create([
            'name'        => 'type.operational',
            'slug'        => [],
            'inherit_id' => $permTypeStaff->getKey(),
            'description' => 'Administra permissoes do type para o nivel operational de usuario'
        ]);
        
        $permTypeManager = Permission::create([
            'name'        => 'type.manager',
            'slug'        => [],
            'inherit_id' => $permTypeOperational->getKey(),
            'description' => 'Administra permissoes do type para o nivel manager de usuario'
        ]);
        
        $permTypeExecutive = Permission::create([
            'name'        => 'type.executive',
            'slug'        => [],
            'inherit_id' => $permTypeManager->getKey(),
            'description' => 'Administra permissoes do type para o nivel executive de usuario'
        ]);
        
        $permTypeAdmin = Permission::create([
            'name'        => 'type.admin',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => true,
                'delete' => true
            ],
            'inherit_id' => $permTypeExecutive->getKey(),
            'description' => 'Administra permissoes do type para o nivel admin de usuario'
        ]);
        
        
        //Assign permissions to rules
        $roleStaff->assignPermission($permTypeStaff);
        $roleOperational->assignPermission($permTypeOperational);
        $roleManager->assignPermission($permTypeManager);
        $roleExecutive->assignPermission($permTypeExecutive);
        $roleAdmin->assignPermission($permTypeAdmin);
        
        //Company
        //Permissions
        $permCompanyStaff = Permission::create([
            'name'        => 'company',
            'slug'        => [
                'create' => false,
                'view'   => false,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do company para o nivel staff de usuario'
        ]);
        
        $permCompanyOperational = Permission::create([
            'name'        => 'company.operational',
            'slug'        => [],
            'inherit_id' => $permCompanyStaff->getKey(),
            'description' => 'Administra permissoes do company para o nivel operational de usuario'
        ]);
        
        $permCompanyManager = Permission::create([
            'name'        => 'company.manager',
            'slug'        => [],
            'inherit_id' => $permCompanyOperational->getKey(),
            'description' => 'Administra permissoes do company para o nivel manager de usuario'
        ]);
        
        $permCompanyExecutive = Permission::create([
            'name'        => 'company.executive',
            'slug'        => [],
            'inherit_id' => $permCompanyManager->getKey(),
            'description' => 'Administra permissoes do company para o nivel executive de usuario'
        ]);
        
        $permCompanyAdmin = Permission::create([
            'name'        => 'company.admin',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => true,
                'delete' => false
            ],
            'inherit_id' => $permCompanyExecutive->getKey(),
            'description' => 'Administra permissoes do company para o nivel admin de usuario'
        ]);
        
        
        //Assign permissions to rules
        $roleStaff->assignPermission($permCompanyStaff);
        $roleOperational->assignPermission($permCompanyOperational);
        $roleManager->assignPermission($permCompanyManager);
        $roleExecutive->assignPermission($permCompanyExecutive);
        $roleAdmin->assignPermission($permCompanyAdmin);
        
        
        //User
        //Permissions
        $permUserStaff = Permission::create([
            'name'        => 'user',
            'slug'        => [
                'create' => false,
                'view'   => false,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do user para o nivel staff de usuario'
        ]);
        
        $permUserOperational = Permission::create([
            'name'        => 'user.operational',
            'slug'        => [],
            'inherit_id' => $permUserStaff->getKey(),
            'description' => 'Administra permissoes do user para o nivel operational de usuario'
        ]);
        
        $permUserManager = Permission::create([
            'name'        => 'user.manager',
            'slug'        => [],
            'inherit_id' => $permUserOperational->getKey(),
            'description' => 'Administra permissoes do user para o nivel manager de usuario'
        ]);
        
        $permUserExecutive = Permission::create([
            'name'        => 'user.executive',
            'slug'        => [],
            'inherit_id' => $permUserManager->getKey(),
            'description' => 'Administra permissoes do user para o nivel executive de usuario'
        ]);
        
        $permUserAdmin = Permission::create([
            'name'        => 'user.admin',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => true,
                'delete' => true
            ],
            'inherit_id' => $permUserExecutive->getKey(),
            'description' => 'Administra permissoes do user para o nivel admin de usuario'
        ]);
        
        
        //Assign permissions to rules
        $roleStaff->assignPermission($permUserStaff);
        $roleOperational->assignPermission($permUserOperational);
        $roleManager->assignPermission($permUserManager);
        $roleExecutive->assignPermission($permUserExecutive);
        $roleAdmin->assignPermission($permUserAdmin);
        
        
        //Assign role to user
    	$user = User::first();
    	if ($user) {
    	    $user->assignRole($roleAdmin);
    	}
    }
}
