<?php

declare(strict_types=1);

namespace Database\Migrations;

use Core\Database\Migration\Migration;
use Database\Schema\ProductsSchema;
use Database\Schema\ProductTranslationsSchema;

class CreateProductsTables extends Migration
{
    public function up(): void
    {
        $this->schema->createFromDefinition(new ProductsSchema());
        $this->schema->createFromDefinition(new ProductTranslationsSchema());
    }

    public function down(): void
    {
        $this->schema->dropIfExists('product_translations');
        $this->schema->dropIfExists('products');
    }
}
