<?php

namespace ESGI\Controllers;

use ESGI\Core\Auth\Auth;
use ESGI\Core\Database\QueryBuilder;
use ESGI\Core\Tools\Mail;
use ESGI\Core\Validation\Validation;
use ESGI\Forms\AuthForm;
use ESGI\Helpers\Token;
use ESGI\Models\GroupsModel;
use ESGI\Models\UsersModel;

class AuthController extends Controller
{
    public function registerAction(): void
    {
        if (Auth::isLogged()) {
            redirect('homepage');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
            $validation = Validation::create(AuthForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('auth.register', 'basic', ['errors' => $validation->getErrors()]);
                return;
            }

            $queryBuilder = (new QueryBuilder)->where('email', '=', $_POST['email']);

            /** @var UsersModel $user */
            $user = UsersModel::fetch($queryBuilder);

            if ($user !== null) {
                $this->render('auth.register', 'basic', ['errors' => ['Cette adresse email est déjà utilisée']]);
                return;
            }

            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $tokenRegistration = Token::generateRandomString(75);

            (new UsersModel)
                ->setLastname($_POST['lastname'])
                ->setFirstname($_POST['firstname'])
                ->setEmail($_POST['email'])
                ->setPassword($password)
                ->setEmailConfirmationToken($tokenRegistration)
                ->insert();

            $queryBuilder = (new QueryBuilder)->where('email', '=', $_POST['email']);

            /** @var UsersModel $user */
            $user = UsersModel::fetch($queryBuilder);

            Auth::login($user);

            $body = 'Bonjour ' . ucwords($user->getFirstname()) . ',<br/>';
            $body .= 'Confirmez votre adresse e-mail en cliquant sur le lien ci-dessous :<br/>';
            $body .= '<a href="' . url('auth.confirmation') . '?token=' . $tokenRegistration . '" >Confirmer mon adresse e-mail<a/>';

            $mail = Mail::create('Confirmez votre adresse e-mail', $body);
            $mail->send($user->getEmail());

            $this->render('administration.confirm', 'backend');
            return;
        }

        $this->render('auth.register', 'basic', ['errors' => []]);
    }

    public function loginAction(): void
    {
        if (Auth::isLogged()) {
            redirect('administration');
        }

        // Remember me feature
        $this->rememberMe();

        $errors = [];
        if (!empty($_POST)) {
            $validation = Validation::create(AuthForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('auth.login', 'basic', ['errors' => $validation->getErrors()]);
                return;
            }

            $queryBuilder = (new QueryBuilder)
                ->join(GroupsModel::getTableName(), 'group_id')
                ->where('email', '=', $_POST['email']);

            /** @var UsersModel|null $user */
            $user = UsersModel::fetch($queryBuilder);

            // Verification
            if ($user && password_verify($_POST['password'], $user->getPassword())) {
                if (!empty($_POST['reminded'])) {
                    $excludedColumns = array_filter(
                        array_keys($user->getAttributes()),
                        static function ($attribute) {
                            return $attribute !== 'token';
                        }
                    );

                    $token = Token::generateRandomString(255);
                    $cookieExpiration = time() + 60 * 60 * 24 * 30; // will set the cookie to expire in 30 days.

                    $user->setToken($token)->update(true, $excludedColumns);

                    setcookie('member_email', $user->getEmail(), $cookieExpiration, '/');
                    setcookie('member_token', $token, $cookieExpiration, '/');
                }

                Auth::login($user);

                redirect('administration');
            } else {
                $errors[] = 'Identifiant ou mot de passe incorrect';
            }
        }

        $this->render('auth.login', 'basic', ['errors' => $errors]);
    }

    public function logoutAction(): void
    {
        if (Auth::isLogged()) {
            Auth::logout();
        }

        redirect('homepage');
    }

    public function confirmationAction(): void
    {
        /** @var UsersModel $user */
        $user = Auth::getUser();

        if ($user !== null && isset($_GET['token']) && $_GET['token'] === $user->getEmailConfirmationToken()) {
            $user->setEmailConfirmed(1)->setEmailConfirmationToken('')->update();
        } else {
            redirect('homepage');
        }

        $this->render('administration.accepted', 'backend');
    }

    public function rememberMe(): void
    {
        if (isset($_COOKIE['member_email'], $_COOKIE['member_token'])) {
            $queryBuilder = (new QueryBuilder)
                ->where('email', '=', $_COOKIE['member_email'])
                ->where('token', '=', $_COOKIE['member_token']);

            /** @var UsersModel|null $user */
            $user = UsersModel::fetch($queryBuilder);

            if ($user instanceof UsersModel) {
                Auth::login($user);

                redirect('administration');
            }
        }
    }
}
