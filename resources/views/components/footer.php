<footer class="footer">
    <div class="container footer-inner">
        <span>&copy; <?= date('Y') ?> <?= e($appName) ?></span>
        <nav class="footer-links">
            <a href="<?= e(route('products.index')) ?>"><?= e(trans('products.title')) ?></a>
            <a href="<?= e(route('login')) ?>"><?= e(trans('auth.login')) ?></a>
        </nav>
    </div>
</footer>
