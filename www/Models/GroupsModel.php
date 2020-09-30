<?php

namespace ESGI\Models;

use ESGI\Core\Forms\Form;
use ESGI\Core\Forms\Input;
use ESGI\Core\Models\ModelInterface;

class GroupsModel extends Model
{
    /** @var string[] */
    protected static $searchableColumns = ['name'];

    /** @var string */
    protected $name;

    /** @var PermissionsModel[] */
    protected $permissions = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return GroupsModel
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return PermissionsModel[]
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @param PermissionsModel[] $permissions
     *
     * @return GroupsModel
     */
    public function setPermissions(array $permissions): GroupsModel
    {
        $this->permissions = $permissions;

        return $this;
    }
}
