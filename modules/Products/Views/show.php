<?php
/** @var Core\View\View $view */
$view->layout('layouts.frontend');
/** @var array<string, mixed> $product */
?>
<section class="container product-detail">
    <p><a class="link" href="<?= e(route('products.index')) ?>">&larr; <?= e(trans('common.back')) ?></a></p>
    <h1><?= e($product['name'] ?? '') ?></h1>
    <p class="product-meta"><?= e(trans('common.sku')) ?>: <?= e($product['sku'] ?? '') ?></p>
    <p class="product-price-lg"><?= e(trans('products.price_label')) ?>: <?= e($product['price'] ?? '') ?></p>
    <div class="product-description">
        <p><?= nl2br(e($product['description'] ?? '')) ?></p>
    </div>
</section>
