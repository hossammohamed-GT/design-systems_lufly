<?php
/** @var Core\View\View $view */
$view->layout('layouts.admin');
/** @var \Modules\Products\Models\Product|null $product */
/** @var array<string, array<string, mixed>> $translations */
$action = $product === null ? route('admin.products.store') : route('admin.products.update', ['id' => $product->id]);
$locales = $translator->locales();
?>
<form method="post" action="<?= e($action) ?>" class="stack admin-form">
    <?= csrf_field() ?>

    <div class="grid grid-2">
        <?= $view->component('input', ['name' => 'sku', 'label' => trans('common.sku'), 'value' => $product->sku ?? '', 'required' => true]) ?>
        <?= $view->component('input', ['name' => 'slug', 'label' => trans('common.slug'), 'value' => $product->slug ?? '']) ?>
        <?= $view->component('input', ['name' => 'price', 'label' => trans('common.price'), 'type' => 'number', 'value' => $product->price ?? '0', 'required' => true]) ?>
        <div class="field">
            <label class="field-label" for="status"><?= e(trans('common.status')) ?></label>
            <?php $status = $product->status ?? 'active'; ?>
            <select class="input" id="status" name="status">
                <?php foreach (['active', 'inactive', 'draft'] as $option): ?>
                    <option value="<?= $option ?>" <?= $status === $option ? 'selected' : '' ?>><?= e(trans('common.' . $option)) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <h2><?= e(trans('common.translations')) ?></h2>
    <?php foreach ($locales as $locale): $tr = $translations[$locale] ?? []; ?>
        <fieldset class="translation-set">
            <legend><?= e(strtoupper($locale)) ?></legend>
            <?= $view->component('input', ['name' => 'name_' . $locale, 'label' => trans('products.name') . ' (' . strtoupper($locale) . ')', 'value' => $tr['name'] ?? '', 'required' => $locale === 'en']) ?>
            <div class="field">
                <label class="field-label" for="description_<?= e($locale) ?>"><?= e(trans('products.description')) ?> (<?= e(strtoupper($locale)) ?>)</label>
                <textarea class="input" id="description_<?= e($locale) ?>" name="description_<?= e($locale) ?>" rows="3"><?= e($tr['description'] ?? '') ?></textarea>
            </div>
        </fieldset>
    <?php endforeach; ?>

    <h2><?= e(trans('common.seo')) ?></h2>
    <?= $view->component('input', ['name' => 'seo_title', 'label' => 'Meta title', 'value' => ($product->seo['title'] ?? '')]) ?>
    <?= $view->component('input', ['name' => 'seo_description', 'label' => 'Meta description', 'value' => ($product->seo['description'] ?? '')]) ?>

    <div class="form-actions">
        <?= $view->component('button', ['label' => trans('common.save'), 'variant' => 'primary', 'type' => 'submit']) ?>
        <?= $view->component('button', ['label' => trans('common.cancel'), 'variant' => 'ghost', 'href' => route('admin.products.index')]) ?>
    </div>
</form>
