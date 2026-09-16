<?php

declare(strict_types=1);

namespace Database\Seeders;

use Core\Database\Seeding\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'sku' => 'LUFLY-001',
                'slug' => 'aurora-smart-lamp',
                'price' => '49.90',
                'translations' => [
                    'en' => ['name' => 'Aurora Smart Lamp', 'short_description' => 'Adaptive lighting for modern workspaces.', 'description' => 'The Aurora Smart Lamp adapts brightness and color temperature to your day.'],
                    'tr' => ['name' => 'Aurora Akıllı Lamba', 'short_description' => 'Modern çalışma alanları için uyarlanabilir aydınlatma.', 'description' => 'Aurora Akıllı Lamba, parlaklığı ve renk sıcaklığını gününüze göre uyarlar.'],
                    'cs' => ['name' => 'Aurora chytrá lampa', 'short_description' => 'Adaptivní osvětlení pro moderní pracoviště.', 'description' => 'Chytrá lampa Aurora přizpůsobí jas a teplotu barev vašemu dni.'],
                ],
            ],
            [
                'sku' => 'LUFLY-002',
                'slug' => 'nimble-desk-organizer',
                'price' => '19.90',
                'translations' => [
                    'en' => ['name' => 'Nimble Desk Organizer', 'short_description' => 'Keep every tool within reach.', 'description' => 'A modular desk organizer built from recycled materials.'],
                    'tr' => ['name' => 'Nimble Masa Düzenleyici', 'short_description' => 'Her araç elinizin altında.', 'description' => 'Geri dönüştürülmüş malzemelerden üretilmiş modüler masa düzenleyici.'],
                    'cs' => ['name' => 'Nimble organizér na stůl', 'short_description' => 'Každý nástroj na dosah ruky.', 'description' => 'Modulární organizér na stůl z recyklovaných materiálů.'],
                ],
            ],
            [
                'sku' => 'LUFLY-003',
                'slug' => 'atlas-travel-bottle',
                'price' => '14.50',
                'translations' => [
                    'en' => ['name' => 'Atlas Travel Bottle', 'short_description' => 'Insulated, leak-proof, carry-on ready.', 'description' => 'The Atlas bottle keeps drinks cold for 24 hours and hot for 12.'],
                    'tr' => ['name' => 'Atlas Seyahat Şişesi', 'short_description' => 'Yalıtımlı, sızdırmaz, kabin boy.', 'description' => 'Atlas şişe içecekleri 24 saat soğuk, 12 saat sıcak tutar.'],
                    'cs' => ['name' => 'Atlas cestovní láhev', 'short_description' => 'Izolovaná, nepropustná, do letadla.', 'description' => 'Láhev Atlas udrží nápoje 24 hodin studené a 12 hodin horké.'],
                ],
            ],
        ];

        foreach ($products as $product) {
            if ($this->db->table('products')->where('sku', $product['sku'])->exists()) {
                continue;
            }

            $productId = $this->db->insert('products', [
                'sku' => $product['sku'],
                'slug' => $product['slug'],
                'price' => $product['price'],
                'status' => 'active',
                'seo' => json_encode(['title' => $product['translations']['en']['name']], JSON_UNESCAPED_UNICODE),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            foreach ($product['translations'] as $locale => $fields) {
                $this->db->insert('product_translations', [
                    'product_id' => (int) $productId,
                    'locale' => $locale,
                    'name' => $fields['name'],
                    'short_description' => $fields['short_description'],
                    'description' => $fields['description'],
                ]);
            }
        }
    }
}
