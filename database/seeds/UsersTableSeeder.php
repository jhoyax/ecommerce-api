<?php

use App\Eloquent\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 5)->create()->each(function ($user) {
            if ($user->id == 1) {
                $user->assignRole(Role::findByName('admin', 'api'));
            }
        });
    }
}
