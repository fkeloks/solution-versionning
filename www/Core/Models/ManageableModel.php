<?php

namespace ESGI\Core\Models;

use ESGI\Core\Database\Database;

trait ManageableModel
{
    /**
     * Insert current model to database
     */
    public function insert(): void
    {
        $pdo = Database::getPdo();
        $table = self::getTableName();
        $attributes = $this->getAttributes();
        $columns = '`' . implode('`, `', array_keys($attributes)) . '`';

        try {
            $sql = 'INSERT INTO ' . $table . ' (' . $columns . ') VALUES ';
            $sql .= '(' . str_repeat('?, ', count($attributes) - 1) . '?);';

            $pdo->prepare($sql)->execute(array_values($attributes));
        } catch (\PDOException $exception) {
            die('Une erreur est survenue lors de l\'insertion des données');
        }
    }

    /**
     * Update current model to database
     *
     * @param bool $hydrate
     * @param array $excludedColumns
     */
    public function update(bool $hydrate = true, array $excludedColumns = []): void
    {
        if ($hydrate) {
            static::hydrate($this, $_POST ?? []);
        }

        $pdo = Database::getPdo();
        $table = self::getTableName();
        $attributes = $this->getAttributes();

        $changes = [];
        $values = [];
        foreach ($attributes as $attribute => $value) {
            if ($attribute !== 'id' && !is_array($value) && !in_array($attribute, $excludedColumns, true)) {
                $changes[] = '`' . $attribute . '`' . ' = ?';

                // Si la valeur est une chaîne vide, on stocke NULL à la place.
                $value = trim($value);
                if ($value === '') {
                    $value = null;
                }

                $values[] = $value;
            }
        }

        try {
            $sql = 'UPDATE ' . $table . ' SET ' . implode(', ', $changes) . ' WHERE id = ' . $this->getId() . ';';
            $pdo->prepare($sql)->execute($values);
        } catch (\PDOException $exception) {
            die('Une erreur est survenue lors de la mise à jour des données');
        }
    }

    /**
     * Delete current model from database
     *
     * @param int|string|int[] $id
     *
     * @return bool true on success or false on failure.
     */
    public static function delete($id): bool
    {
        $pdo = Database::getPdo();
        $table = self::getTableName();

        if (is_int($id) || is_string($id)) {
            $sql = 'DELETE FROM ' . $table . ' WHERE id = ?;';
            $id = [$id];
        } elseif (is_array($id) && !empty($id)) {
            $sql = 'DELETE FROM ' . $table . ' WHERE id IN (' . str_repeat('?, ', count($id) - 1) . '?);';
        } else {
            return false;
        }

        $statement = $pdo->prepare($sql);

        return $statement->execute($id);
    }
}
