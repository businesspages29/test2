<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//custom
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
        	'name' => 'Bhargav Raviya', 
        	'email' => 'admin@rajtechnologies.com',
        	'password' => bcrypt('123456789')
        ]);

        $user = User::create([
        	'name' => 'Bhargav Raviya', 
        	'email' => 'applocumadmin@yopmail.com',
        	'password' => bcrypt('Password@123')
        ]);
        
  
        $role = Role::create(['name' => 'Admin']);
   
        $permissions = Permission::pluck('id','id')->all();
  
        $role->syncPermissions($permissions);
   
        $user->assignRole([$role->id]);
    }
}
