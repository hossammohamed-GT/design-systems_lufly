<?php
/** @var Core\View\View $view */
$view->layout('layouts.frontend');
/** @var Core\Database\Paginator $paginator */
/** @var string $locale */
?>
<section class="container">
    <header class="page-header">
        <h1><?= e(trans('products.title')) ?></h1>
    </header>

    <?php if ($paginator->items() === []): ?>
        <p class="empty-state"><?= e(trans('products.empty')) ?></p>
    <?php else: ?>
        <div class="grid grid-3">
            <?php foreach ($paginator->items() as $product): $item = $product->translate($locale); ?>
                <article class="card product-card">
                    <div class="card-body">
                        <h2 class="card-title"><?= e($item['name'] ?? '') ?></h2>
                        <p class="card-subtitle"><?= e($item['short_description'] ?? '') ?></p>
                        <p class="product-price"><?= e(trans('products.price_label')) ?>: <?= e($item['price'] ?? '') ?></p>
                    </div>
                    <div class="card-footer">
                        <?= $view->component('button', ['label' => trans('products.view_details'), 'variant' => 'secondary', 'size' => 'sm', 'href' => route('products.show', ['slug' => $item['slug']])]) ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?php if ($paginator->lastPage() > 1): ?>
            <nav class="pagination">
                <?php for ($p = 1; $p <= $paginator->lastPage(); $p++): ?>
                    <a class="page-link<?= $p === $paginator->page() ? ' is-active' : '' ?>"
                       href="?page=<?= $p ?>"><?= $p ?></a>
                <?php endfor; ?>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</section>
