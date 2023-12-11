<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $reader = Role::where('slug', 'reader')->first();
        $admin = Role::where('slug', 'admin')->first();

        $createComments = Permission::where('slug', 'create comments')->first();
        $deleteComments = Permission::where('slug', 'delete comments')->first();
        $editComments = Permission::where('slug', 'edit comments')->first();
        $createArticles = Permission::where('slug', 'create article')->first();
        $editArticles = Permission::where('slug', 'edit article')->first();
        $deleteArticles = Permission::where('slug', 'delete article')->first();

        $admin->permissions()->attach([$createComments->id, $deleteComments->id, $editComments->id, $createArticles->id, $editArticles->id, $deleteArticles->id]);
        $reader->permissions()->attach($createComments);

        $adminUser = User::where('name', 'Admin')->first();
        $adminUser->roles()->attach($admin);
        $adminUser->permissions()->attach([$createComments->id, $deleteComments->id, $editComments->id, $createArticles->id, $editArticles->id, $deleteArticles->id]);
        foreach(User::all() as $user) {
            if ($user->name != 'Admin') {
                $user->roles()->attach($reader);
                $user->permissions()->attach($createComments);
            }
        }
    }
}
