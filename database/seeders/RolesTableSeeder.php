<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Amministratore',

            ],
            [
                'name' => 'user',
                'display_name' => 'Utente semplice',

            ], [
                'name' => 'collaborator',
                'display_name' => 'Collaboratore esterno',

            ],
        ];

        foreach ($roles as $role) {
            $role = new Role();
            $role->name = $role['name'];
            $role->description = $role['display_name'];
            $role->save();
        }
    }
}
