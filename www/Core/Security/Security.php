<?php

namespace ESGI\Core\Security;

use ESGI\Core\Auth\Auth;
use ESGI\Core\Database\QueryBuilder;
use ESGI\Models\GroupsModel;
use ESGI\Models\GroupsPermissionsModel;
use ESGI\Models\PermissionsModel;
use ESGI\Models\UsersModel;

class Security
{
    /**
     * Throw an error if current user have not permission
     *
     * @param string $permissionName
     *
     * @throws NotAllowedException
     */
    public static function mustHavePermissionTo(string $permissionName): void
    {
        if (!self::hasPermissionTo($permissionName)) {
            throw new NotAllowedException;
        }
    }

    /**
     * Determine if current user have a permission
     *
     * @param string $permissionName
     *
     * @return bool
     */
    public static function hasPermissionTo(string $permissionName): bool
    {
        if (!Auth::isLogged()) {
            return false;
        }

        $permissions = self::getPermissions();

        foreach ($permissions as $permission) {
            if ($permission->getPermission()->getName() === $permissionName) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns current user permissions
     *
     * @return GroupsPermissionsModel[]
     */
    private static function getPermissions(): array
    {
        /** @var UsersModel $user */
        $user = Auth::getUser();

        // If current user has group
        if ($user->getGroup() instanceof GroupsModel) {
            $queryBuilder = (new QueryBuilder)
                ->join(GroupsModel::getTableName(), 'group_id')
                ->join(PermissionsModel::getTableName(), 'permission_id')
                ->whereRaw('groups.id = \'' . $user->getGroup()->getId() . '\'');

            return GroupsPermissionsModel::fetchAll($queryBuilder);
        }

        return [];
    }
}
