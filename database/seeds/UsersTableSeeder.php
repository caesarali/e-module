<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'dosen', 'mahasiswa'];

        foreach ($roles as $role) {
	        Role::create([
	        	'name' => $role
	        ]);
        }

        $admin = new User;
        $admin->username = 'Administrator';
        $admin->email = 'admin@e-module';
        $admin->password = bcrypt('admin');
        $admin->save();
        $admin->attachRole('admin');
    }
}
