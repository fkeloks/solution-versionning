<?php /** @var \ESGI\Models\AnnouncementsModel $announcement */ ?>
<?php /** @var \ESGI\Models\ModulesModel[] $modules */ ?>
<?php /** @var string[] $errors */ ?>

<?= view('page', [
    'modules' => array_filter($modules, static function ($module) {
        return $module->getName() !== 'footer';
    })
]) ?>

<div class="margin-top-40">
    <div class="card">
        <h5 class="card-title title-5">Comment procéder ?</h5>
        <p class="card-text">
            Des messages visant à récupérer vos informations personnelles (Carte d’identité, factures, RIB,
            identifiants, code d’accès…) circulant actuellement.
            Ces messages ne proviennent pas de nos services.
            Si vous pensez avoir reçu un message suspect, nous vous invitons à contacter notre service client pour
            vérification en fournissant l’adresse expéditrice, son contenu ou encore le lien du site sur lequel vous
            êtes redirigé.
        </p>
        <p class="card-text">
            Nous vous proposons de nous exposer le motif de votre demande dans le formulaire ci-dessous.
            Si vous souhaitez obtenir plus de réponses à votre question, vous pouvez détailler votre demande via le
            formulaire de contact, nous y apporterons une réponse sous 24 heures. Toutefois, si elle nécessite une
            expertise plus approfondie, ce délai peut être étendu à 6 jours ouvrés.
        </p>
    </div>
</div>

<h1 class="title-4">
    <?php $address = explode(' ', htmlentities($announcement->getProperty()->getAddress())) ?>
    Signaler l'annonce "<?= \ESGI\Models\AnnouncementsModel::TYPES[$announcement->getType()] ?> à <?= end($address) ?>"
</h1>

<?php if (!empty($message)): ?>
    <div class="card margin-top-20">
        <div class="card-text">
            <h5 class="card-title title-5"><?= htmlentities($message) ?></h5>
        </div>
    </div>
<?php else: ?>
    <?= view('parts.errors', ['errors' => $errors]) ?>
    <?= form('reports') ?>
<?php endif; ?>

<?= view('page', [
    'modules' => array_filter($modules, static function ($module) {
        return $module->getName() === 'footer';
    })
]) ?>
