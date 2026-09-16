<?php

declare(strict_types=1);

namespace Database\Seeders;

use Core\Database\Seeding\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'admin@lufly.test';

        if ($this->db->table('users')->where('email', $email)->exists()) {
            return;
        }

        $userId = $this->db->insert('users', [
            'name' => 'Lufly Admin',
            'email' => $email,
            'password' => password_hash('password', PASSWORD_BCRYPT, ['cost' => 12]),
            'locale' => 'en',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $role = $this->db->selectOne('SELECT id FROM roles WHERE name = ?', ['admin']);
        if ($role !== null) {
            $this->db->insert('user_roles', [
                'user_id' => (int) $userId,
                'role_id' => (int) $role['id'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
