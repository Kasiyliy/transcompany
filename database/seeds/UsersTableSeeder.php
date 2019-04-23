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
        $user = new User();
        $user->first_name = "Admin";
        $user->last_name = "Admin";
        $user->phone_number = "8-777-777-77-77";
        $user->email = "admin@mail.kz";
        $user->password = bcrypt('112233');
        $user->untouchable = true;
        $user->role_id = Role::ADMIN_ID;
        $user->save();

    }
}
