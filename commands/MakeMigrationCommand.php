<?php

namespace ESGI\Commands;

class MakeMigrationCommand implements CommandInterface
{
    public static function process(array $arguments): void
    {
        $name = $arguments[2] ?? null;
        if (!$name) {
            echo 'Le nom de la migration doit être renseigné.';
            exit();
        }

        $filename = date('Y_m_d_His') . '_' . str_replace('-', '_', $name) . '.sql';
        file_put_contents('migrations' . DIRECTORY_SEPARATOR . $filename, '# ...');

        echo 'La migration à bien été créée : ' . $filename . PHP_EOL;
    }
}
