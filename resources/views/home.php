<?php
/** @var Core\View\View $view */
$view->layout('layouts.frontend');
?>
<section class="container hero">
    <div class="hero-copy">
        <p class="eyebrow"><?= e($appName) ?></p>
        <h1 class="hero-title"><?= e(trans('home.hero_title')) ?></h1>
        <p class="hero-subtitle"><?= e(trans('home.hero_subtitle')) ?></p>
        <div class="hero-actions">
            <?= $view->component('button', ['label' => trans('home.cta_products'), 'variant' => 'primary', 'href' => route('products.index')]) ?>
            <?php if (auth()->check()): ?>
                <?= $view->component('button', ['label' => trans('home.cta_admin'), 'variant' => 'ghost', 'href' => route('admin.dashboard')]) ?>
            <?php else: ?>
                <?= $view->component('button', ['label' => trans('auth.login'), 'variant' => 'ghost', 'href' => route('login')]) ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="container">
    <h2 class="section-title"><?= e(trans('home.features_title')) ?></h2>
    <div class="grid grid-3">
        <?= $view->component('card', ['title' => trans('home.feature_modules')], null) ?>
        <?= $view->component('card', ['title' => trans('home.feature_localization')], null) ?>
        <?= $view->component('card', ['title' => trans('home.feature_api')], null) ?>
    </div>
    <div class="grid grid-3 feature-desc">
        <p><?= e(trans('home.feature_modules_desc')) ?></p>
        <p><?= e(trans('home.feature_localization_desc')) ?></p>
        <p><?= e(trans('home.feature_api_desc')) ?></p>
    </div>
</section>
