<?php if (!empty($errors)): ?>
    <div>
        <p><?= count($errors) > 1 ? 'Erreurs' : 'Erreur' ?> :</p>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
