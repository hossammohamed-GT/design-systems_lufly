<?php

declare(strict_types=1);

namespace Database\Seeders;

use Core\Database\Seeding\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'company_name' => 'Lufly',
            'contact_email' => 'hello@lufly.test',
            'contact_phone' => '+90 000 000 00 00',
            'default_meta_description' => 'Enterprise multilingual platform foundation built with native PHP.',
        ];

        foreach ($settings as $key => $value) {
            if (!$this->db->table('settings')->where('key', $key)->exists()) {
                $this->db->insert('settings', [
                    'key' => $key,
                    'value' => json_encode($value, JSON_UNESCAPED_UNICODE),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
