<?php
/** @var Core\View\View $view */
$view->layout('layouts.admin');
/** @var array<int, \Modules\Media\Models\Media> $items */
?>
<form method="post" action="<?= e(route('admin.media.store')) ?>" enctype="multipart/form-data" class="stack admin-form">
    <?= csrf_field() ?>
    <div class="grid grid-2">
        <div class="field">
            <label class="field-label" for="file">File</label>
            <input class="input" type="file" id="file" name="file" required>
        </div>
        <?= $view->component('input', ['name' => 'collection', 'label' => 'Collection', 'value' => 'general']) ?>
    </div>
    <?= $view->component('button', ['label' => trans('common.uploaded'), 'variant' => 'primary', 'type' => 'submit']) ?>
</form>

<table class="table">
    <thead>
        <tr>
            <th>ID</th><th>File</th><th>Type</th><th>Size (KB)</th><th>Collection</th><th><?= e(trans('common.actions')) ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $media): ?>
            <tr>
                <td><?= (int) $media->id ?></td>
                <td><?= e($media->original_name) ?></td>
                <td><?= e($media->mime_type) ?></td>
                <td><?= (int) round(((int) $media->size) / 1024) ?></td>
                <td><?= e($media->collection) ?></td>
                <td>
                    <form method="post" action="<?= e(route('admin.media.destroy', ['id' => $media->id])) ?>" class="inline-form"
                          onsubmit="return confirm('OK?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-danger"><?= e(trans('common.delete')) ?></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
