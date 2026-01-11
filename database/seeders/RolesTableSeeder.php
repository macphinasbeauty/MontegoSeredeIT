<?php

namespace Database\Seeders;

use App\Models\Role;
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
                'name' => 'super_admin',
                'description' => 'Super Administrator with full system access'
            ],
            [
                'name' => 'admin',
                'description' => 'Administrator with management capabilities'
            ],
            [
                'name' => 'agent',
                'description' => 'Travel agent with booking capabilities'
            ],
            [
                'name' => 'customer',
                'description' => 'Regular customer user'
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                ['description' => $role['description']]
            );
        }
    }
}
