<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // deklrasi variabel untuk permissions
        $permissions = [
            'view courses',
            'create courses',
            'edit courses',
            'delete courses',
        ];

        // foreach untuk dimasukan ke DB
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        // buat role
        $TeacherRole = Role::create([
            'name' => 'teacher'
        ]);

        // berikan role yang telah dibuat
        $TeacherRole->givePermissionTo([
            'view courses',
            'create courses',
            'edit courses',
            'delete courses',
        ]);

        // buat role
        $StudentRole = Role::create([
            'name' => 'student'
        ]);

        // berikan role yang telah dibuat
        $StudentRole->givePermissionTo([
            'view courses',
        ]);

        // buat role super_admin
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
        ]);

        $AdminRole = Role::create([
            'name' => 'admin'
        ]);

        // berikan role yang telah dibuat
        $AdminRole->givePermissionTo([
            'view courses',
            'create courses',
            'edit courses',
            'delete courses',
        ]);

        $user->assignRole($AdminRole);
    }
}
