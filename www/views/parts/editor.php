<?php /** @var string $name */ ?>
<?php /** @var string|null $value */ ?>
<?php /** @var string $type */ ?>

<?php if (!defined('WYSIWYG_LOADED')): ?>
    <!-- Include external CSS. -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">

    <!-- Include Editor style. -->
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_style.min.css" rel="stylesheet" type="text/css"/>

    <!-- Include external JS libs. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

    <!-- Include Editor JS files. -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js"></script>
    <?php define('WYSIWYG_LOADED', true); ?>
<?php endif; ?>

<textarea name="<?= $name ?? 'content' ?>" id="<?= $name ?? 'content' ?>"><?= $value ?? '' ?></textarea>
<?= view('parts.fields.' . $type, ['name' => $name]) ?>
