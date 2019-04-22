<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $admin = new Role();
        $admin->name="Админ";
        $admin->save();

        $vendor = new Role();
        $vendor->name="Пользователь";
        $vendor->save();
    }
}
