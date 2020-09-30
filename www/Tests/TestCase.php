<?php

namespace ESGI\Tests;

use ESGI\Core\Auth\Auth;
use ESGI\Core\Database\QueryBuilder;
use ESGI\Models\GroupsModel;
use ESGI\Models\UsersModel;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function asAnonymousUser(): void
    {
        if (Auth::isLogged()) {
            Auth::logout();
        }
    }

    public function asAuthenticatedUser(string $email): void
    {
        $queryBuilder = (new QueryBuilder)
            ->join(GroupsModel::getTableName(), 'group_id')
            ->where('email', '=', $email);

        /** @var UsersModel $user */
        $user = UsersModel::fetch($queryBuilder);

        Auth::login($user);
    }
}
