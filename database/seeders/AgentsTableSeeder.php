<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AgentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the agent role
        $agentRole = Role::where('name', 'agent')->first();

        // Create sample agents with associated users
        $agents = [
            [
                'name' => 'John Travel Agent',
                'email' => 'john.agent@milestour.com',
                'phone' => '+254700000001',
                'company' => 'MileTour Travel Agency',
                'address' => '123 Koinange Street, Nairobi, Kenya',
                'user_data' => [
                    'name' => 'John Agent',
                    'email' => 'john.agent@milestour.com',
                    'password' => 'password123',
                    'is_admin' => false,
                ]
            ],
            [
                'name' => 'Sarah Booking Specialist',
                'email' => 'sarah.agent@milestour.com',
                'phone' => '+254700000002',
                'company' => 'DreamsTour Agents',
                'address' => '456 Moi Avenue, Mombasa, Kenya',
                'user_data' => [
                    'name' => 'Sarah Specialist',
                    'email' => 'sarah.agent@milestour.com',
                    'password' => 'password123',
                    'is_admin' => false,
                ]
            ],
            [
                'name' => 'Michael Cruise Expert',
                'email' => 'michael.agent@milestour.com',
                'phone' => '+254700000003',
                'company' => 'Coastal Travel Services',
                'address' => '789 Luthuli Avenue, Kisumu, Kenya',
                'user_data' => [
                    'name' => 'Michael Expert',
                    'email' => 'michael.agent@milestour.com',
                    'password' => 'password123',
                    'is_admin' => false,
                ]
            ],
        ];

        foreach ($agents as $agentData) {
            // Create or update user account
            $userData = $agentData['user_data'];
            unset($agentData['user_data']);

            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'is_admin' => $userData['is_admin'],
                    'role_id' => $agentRole ? $agentRole->id : null,
                ]
            );

            // Create agent record
            Agent::updateOrCreate(
                ['email' => $agentData['email']],
                array_merge($agentData, ['user_id' => $user->id])
            );
        }
    }
}
