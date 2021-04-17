<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	/*writer permissions*/
        $role=\Spatie\Permission\Models\Role::create([
        	"name"=>"writer"
        ]);
        $permissions=[
    		\Spatie\Permission\Models\Permission::create([
        		"name"=>"write post"
        	]),
        	\Spatie\Permission\Models\Permission::create([
        		"name"=>"edit post"
        	]),
        	\Spatie\Permission\Models\Permission::create([
        		"name"=>"delete post"
        	])
        ];
        foreach ($permissions as $permission) {
        	
        	$role->givePermissionTo($permission);
        }

        /*admin permisions*/
        $role=\Spatie\Permission\Models\Role::create([
        	"name"=>"admin"
        ]);
        $permissions=[
    		\Spatie\Permission\Models\Permission::create([
        		"name"=>"create user"
        	]),
        	\Spatie\Permission\Models\Permission::create([
        		"name"=>"edit user"
        	]),
        	\Spatie\Permission\Models\Permission::create([
        		"name"=>"delete user"
        	])
        ];
        foreach ($permissions as $permission) {
        	
        	$role->givePermissionTo($permission);
        }
        User::where("id",1)->first()->assignRole("admin");
    }
}
