<?php
/**
 * Props: id, title. Slot: body content.
 */
$id = $props['id'] ?? 'modal';
$title = $props['title'] ?? '';
?>
<div class="modal-backdrop" id="<?= e($id) ?>" data-modal hidden>
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="<?= e($id) ?>-title">
        <div class="modal-header">
            <h3 class="modal-title" id="<?= e($id) ?>-title"><?= e($title) ?></h3>
            <button type="button" class="modal-close" data-modal-close aria-label="<?= e(trans('common.cancel')) ?>">&times;</button>
        </div>
        <div class="modal-body"><?= $slot ?? '' ?></div>
    </div>
</div>
