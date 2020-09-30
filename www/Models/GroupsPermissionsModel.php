<?php

namespace ESGI\Models;

class GroupsPermissionsModel extends Model
{
    /** @var int */
    protected $group_id;

    /** @var GroupsModel */
    protected $group;

    /** @var int */
    protected $permission_id;

    /** @var PermissionsModel */
    protected $permission;

    /**
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->group_id;
    }

    /**
     * @param int $group_id
     */
    public function setGroupId(int $group_id): void
    {
        $this->group_id = $group_id;
    }

    public function getGroup(): GroupsModel
    {
        return $this->group;
    }

    /**
     * @return int
     */
    public function getPermissionId(): int
    {
        return $this->permission_id;
    }

    /**
     * @param int $permission_id
     */
    public function setPermissionId(int $permission_id): void
    {
        $this->permission_id = $permission_id;
    }

    public function getPermission(): PermissionsModel
    {
        return $this->permission;
    }
}
