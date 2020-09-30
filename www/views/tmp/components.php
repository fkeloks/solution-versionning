<h1 class="title-3">Page temporaire - composants du site</h1>

<h2 class="title-4 margin-top-20">Boutons</h2>

<button class="button button-blue">Afficher</button>
<button class="button button-black">Retour</button>
<button class="button button-green">Confirmer</button>
<button class="button button-red">Supprimer</button>
<button class="button button-orange">Bloquer</button>

<h2 class="title-4 margin-top-20">Boutons avec icônes</h2>
<button class="button button-black"><?= icon('back') ?> Retour</button>
<button class="button button-blue"><?= icon('add') ?> Ajouter</button>

<h2 class="title-4 margin-top-20">Grille</h2>
<div class="row">
    <?php for ($i = 1; $i <= 12; $i++): ?>
        <div class="col-1">
            <span class="grid-example margin-top-0"><?= $i ?></span>
        </div>
    <?php endfor; ?>

    <?php for ($i = 1; $i <= 2; $i++): ?>
        <div class="col-12 col-md-6">
            <span class="grid-example">col-12 col-md-6</span>
        </div>
    <?php endfor; ?>

    <?php for ($i = 1; $i <= 3; $i++): ?>
        <div class="col-12 col-md-4">
            <span class="grid-example">col-2 col-md-4</span>
        </div>
    <?php endfor; ?>

    <?php for ($i = 1; $i <= 4; $i++): ?>
        <div class="col-3">
            <span class="grid-example">col-3</span>
        </div>
    <?php endfor; ?>

    <?php foreach ([2, 8, 2] as $i): ?>
        <div class="col-<?= $i ?>">
            <span class="grid-example">col-<?= $i ?></span>
        </div>
    <?php endforeach; ?>
</div>

<h2 class="title-4 margin-top-20">Pagination</h2>
<div class="pagination margin-0">
    <a href="" class="pagination-item">Précédent</a>
    <a href="" class="pagination-item">2</a>
    <a href="" class="pagination-item active">3</a>
    <a href="" class="pagination-item">4</a>
    <a href="" class="pagination-item">Suivant</a>
</div>
<div class="pagination margin-0">
    <a href="" class="pagination-item">1</a>
    <a href="" class="pagination-item">2</a>
    <a href="" class="pagination-item active">3</a>
    <a href="" class="pagination-item">4</a>
    <a href="" class="pagination-item">5</a>
</div>
