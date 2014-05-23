<?php
 
class UserTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('assigned_roles')->truncate();
        DB::table('permission_role')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();

        $role1 = Role::create(array('name' => 'Rolle 1'));
        $role2 = Role::create(array('name' => 'Rolle 2'));

        $permission1 = Permission::create(array('name' => 'Rettighet 1', 'display_name' => 'Rettighet 1'));
        $permission2 = Permission::create(array('name' => 'Rettighet 2', 'display_name' => 'Rettighet 2'));

        $role1->attachPermission($permission1);
        $role2->attachPermission($permission1);
        $role2->attachPermission($permission2);

        $user1 = User::create(array(
            'email' => 'jostein.skaar@gmail.com',
            'password' => Hash::make('password1'),
            'full_name' => "Jostein Skaar"            
        ));

        $user1->attachRole($role1);        

 
        $user2 = User::create(array(
            'email' => 'josteinskaar@gmail.com',
            'password' => Hash::make('password2'),
            'full_name' => "Bruker 2"
        ));        

        $user2->attachRole($role2);
    }
 
}