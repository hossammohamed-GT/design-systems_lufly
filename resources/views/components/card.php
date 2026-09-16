<?php
/**
 * Props: title, subtitle, footer. Slot: body content.
 */
$title = $props['title'] ?? '';
$subtitle = $props['subtitle'] ?? '';
$footer = $props['footer'] ?? '';
?>
<div class="card">
    <?php if ($title !== ''): ?>
        <div class="card-header">
            <h3 class="card-title"><?= e($title) ?></h3>
            <?php if ($subtitle !== ''): ?><p class="card-subtitle"><?= e($subtitle) ?></p><?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="card-body"><?= $slot ?? '' ?></div>
    <?php if ($footer !== ''): ?><div class="card-footer"><?= $footer ?></div><?php endif; ?>
</div>
