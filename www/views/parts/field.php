<?php
/** @var array $field */
/** @var integer $index */
/** @var array $instance */

$name = 'field-' . mt_rand() . '-' . $field['name'] . '-' . ($index ?? 0);

$attributes = [];
foreach ($field['attributes'] ?? [] as $attribute => $value) {
    $attributes[] = $attribute . '="' . $value . '"';
}

$value = null;
$formattedValue = null;
if (!empty($instance) && !empty($instance[$field['name']])) {
    $value = $instance[$field['name']];
    $formattedValue = 'value="' . $instance[$field['name']] . '"';
}
?>

<div class="form-group">
    <label for="<?= $name ?>"><?= $field['label'] ?></label>
    <?php if ($field['attributes']['type'] === 'textarea'): ?>
        <textarea name="<?= $name ?>" id="<?= $name ?>" <?= implode(' ', $attributes) ?>><?= $value ?: '' ?></textarea>
    <?php elseif ($field['attributes']['type'] === 'wysiwyg' || $field['attributes']['type'] === 'image'): ?>
        <?= view('parts.editor', ['name' => $name, 'value' => $value, 'type' => $field['attributes']['type']]) ?>
    <?php else: ?>
        <input name="<?= $name ?>" id="<?= $name ?>" <?= implode(' ', $attributes) ?> <?= $formattedValue ?: '' ?>>
    <?php endif; ?>
</div>
