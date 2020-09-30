<?php

namespace ESGI\Tests\Security;

use ESGI\Controllers\AdministrationController;
use ESGI\Controllers\AnnouncementsController;
use ESGI\Controllers\PagesController;
use ESGI\Core\Auth\Auth;
use ESGI\Core\Security\NotAllowedException;
use ESGI\Tests\TestCase;

class SecurityTest extends TestCase
{
    public function testUserAuthentification(): void
    {
        $this->asAuthenticatedUser('flo@immo.fr');

        $this->assertTrue(Auth::isLogged());
        $this->assertEquals('flo@immo.fr', Auth::getUser()->getEmail());
        $this->assertEquals('Administrateurs', Auth::getUser()->getGroup()->getName());
    }

    public function testNoAccessIfNotAuthenticated(): void
    {
        $this->asAnonymousUser();

        (new AnnouncementsController)->callAction('indexAction');
        (new AnnouncementsController)->callAction('addAction');

        $this->expectException(NotAllowedException::class);
        (new PagesController)->callAction('indexAction');
    }

    public function testAccessWithAuthenticatedUser(): void
    {
        $this->asAuthenticatedUser('flo@immo.fr');

        (new AdministrationController)->callAction('indexAction');

        Auth::getUser()->getGroup()->setId(2);
        Auth::login(Auth::getUser());

        $this->expectException(NotAllowedException::class);
        (new PagesController)->callAction('indexAction');
    }

    /**
     * @dataProvider securityCheckProvider
     *
     * @param $groupId
     * @param $controller
     * @param $action
     * @param $willThrowException
     */
    public function testPermissionGroupWithAuthenticatedUser($groupId, $controller, $action, $willThrowException): void
    {
        if ($willThrowException) {
            $this->asAuthenticatedUser('flo@immo.fr');
            Auth::getUser()->getGroup()->setId($groupId);
            Auth::login(Auth::getUser());

            $this->expectException(NotAllowedException::class);
            (new $controller)->callAction('indexAction');
        } else {
            $this->asAuthenticatedUser('flo@immo.fr');
            Auth::getUser()->getGroup()->setId($groupId);
            Auth::login(Auth::getUser());

            (new $controller)->callAction('indexAction');

            $this->asAnonymousUser();
            $this->expectException(NotAllowedException::class);
            (new $controller)->callAction($action);
        }
    }

    public function securityCheckProvider(): array
    {
        return [
            // Administrators
            [1, PagesController::class, 'indexAction', false],
            [1, PagesController::class, 'addAction', false],
            [1, PagesController::class, 'editAction', false],
            [1, PagesController::class, 'deleteAction', false],

            // Moderators
            [2, PagesController::class, 'indexAction', true],
            [2, PagesController::class, 'addAction', true],
            [2, PagesController::class, 'editAction', true],
            [2, PagesController::class, 'deleteAction', true],
        ];
    }
}
