<?php
/** @var Core\View\View $view */
?>
<header class="navbar">
    <div class="navbar-inner container">
        <a class="navbar-brand" href="<?= e(route('home')) ?>">
            <img src="<?= e(asset('frontend/design-system/logo.png')) ?>" alt="" class="navbar-logo">
            <?= e($appName) ?>
        </a>
        <nav class="navbar-links">
            <a href="<?= e(route('home')) ?>"><?= e(trans('home.hero_title')) ?></a>
            <a href="<?= e(route('products.index')) ?>"><?= e(trans('products.title')) ?></a>
            <?php if (auth()->check()): ?>
                <a href="<?= e(route('admin.dashboard')) ?>"><?= e(trans('common.admin_panel')) ?></a>
            <?php else: ?>
                <a href="<?= e(route('login')) ?>"><?= e(trans('auth.login')) ?></a>
            <?php endif; ?>
        </nav>
        <div class="navbar-actions">
            <?= $view->renderFile($view->resolvePath('components.language-switcher'), []) ?>
            <?= $view->renderFile($view->resolvePath('components.theme-switcher'), []) ?>
        </div>
    </div>
</header>
