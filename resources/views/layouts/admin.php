<?php
/** @var Core\View\View $view */
/** @var string $content */
/** @var string $title */
$translator = $translator ?? null;
$locale = $translator instanceof \Core\Localization\Translator ? $translator->getLocale() : (string) config('localization.default', 'en');
?>
<!DOCTYPE html>
<html lang="<?= e($locale) ?>" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(($title ?? 'Admin') . ' — ' . $appName) ?></title>
<link rel="stylesheet" href="<?= e(asset('frontend/design-system/colors.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('frontend/design-system/spacing.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('frontend/design-system/typography.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('frontend/design-system/radius.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('frontend/design-system/shadows.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('frontend/design-system/animations.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('frontend/design-system/themes.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('frontend/design-system/components.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('admin/assets/admin.css')) ?>">
</head>
<body class="ds-app admin-body">
<div class="admin-shell">
    <aside class="admin-sidebar">
        <div class="admin-brand"><?= e($appName) ?></div>
        <nav class="admin-nav">
            <a href="<?= e(route('admin.dashboard')) ?>"><?= e(trans('common.dashboard')) ?></a>
            <a href="<?= e(route('admin.products.index')) ?>"><?= e(trans('common.products')) ?></a>
            <a href="<?= e(route('admin.users.index')) ?>"><?= e(trans('common.users')) ?></a>
            <a href="<?= e(route('admin.roles.index')) ?>"><?= e(trans('common.roles_permissions')) ?></a>
            <a href="<?= e(route('admin.languages.index')) ?>"><?= e(trans('common.languages')) ?></a>
            <a href="<?= e(route('admin.media.index')) ?>"><?= e(trans('common.media_library')) ?></a>
            <a href="<?= e(route('admin.settings.index')) ?>"><?= e(trans('common.settings')) ?></a>
            <a href="<?= e(route('admin.seo.index')) ?>"><?= e(trans('common.seo')) ?></a>
        </nav>
    </aside>
    <div class="admin-main">
        <header class="admin-topbar">
            <h1 class="admin-title"><?= e($title ?? '') ?></h1>
            <div class="admin-topbar-actions">
                <?= $view->renderFile($view->resolvePath('components.theme-switcher'), []) ?>
                <a class="btn btn-ghost" href="<?= e(route('home')) ?>"><?= e(trans('common.view_site')) ?></a>
                <form method="post" action="<?= e(url('/logout')) ?>" class="inline-form">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-ghost"><?= e(trans('auth.logout')) ?></button>
                </form>
            </div>
        </header>
        <div class="admin-content">
            <?= $view->renderFile($view->resolvePath('components.alert'), []) ?>
            <?= $content ?>
        </div>
    </div>
</div>
<script src="<?= e(asset('frontend/js/theme-switcher.js')) ?>"></script>
<script src="<?= e(asset('frontend/js/modal.js')) ?>"></script>
</body>
</html>
