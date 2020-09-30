<?php
/** @var \ESGI\Models\PagesModel $page */

use ESGI\Core\Configuration\Config;

$title = isset($page) && $page ? $page->getTitle() . ' - ' : '';
$title .= Config::get('site.name');

if (isset($page) && $page && trim($page->getDescription())) {
    $description = trim($page->getDescription());
} else {
    $description = Config::get('site.description');
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="language" content="fr"/>
    <meta name="description" content="<?= htmlentities($description) ?>">
    <meta name="keywords" content="<?= htmlentities(Config::get('site.keywords')) ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="128x128" href="/favicon.png"/>
    <link rel="apple-touch-icon" type="image/png" sizes="128x128" href="/favicon.png"/>

    <!-- Open Graph -->
    <meta property="og:title" content="<?= htmlentities($title) ?>"/>
    <meta property="og:description" content="<?= htmlentities($description) ?>"/>
    <meta property="og:url" content="<?= url('homepage') ?>"/>
    <meta property="og:language" content="fr"/>

    <!-- Twitter -->
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:site" content="<?= htmlentities(Config::get('site.twitter')) ?>"/>
    <meta name="twitter:creator" content="<?= htmlentities(Config::get('site.twitter')) ?>"/>

    <title><?= htmlentities($title) ?></title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= url('homepage') ?>dist/css/app.css">
    <link rel="stylesheet" href="<?= url('homepage') ?>dist/css/themes/<?= Config::get('site.theme') ?>.css">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-83686112-12"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-83686112-12');
    </script>
</head>
