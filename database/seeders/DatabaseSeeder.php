<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role; 
use Spatie\Permission\Models\Permission; 

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Permissões para arquivos
        Permission::create(['name' => 'files.upload']);
        Permission::create(['name' => 'files.delete']);
        Permission::create(['name' => 'files.share']);

        // Atribuir permissões ao papel admin
        $adminRole->givePermissionTo([
            'files.upload',
            'files.delete',
            'files.share'
    ]);

        // User::factory(10)->withPersonalTeam()->create();

        User::factory()->withPersonalTeam()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }

}
