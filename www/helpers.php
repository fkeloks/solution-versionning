<?php

use ESGI\Core\Forms\Form;
use ESGI\Core\Models\ModelInterface;
use ESGI\Helpers\Debug;
use ESGI\Helpers\Icon;
use ESGI\Helpers\Route;
use ESGI\Helpers\Text;
use ESGI\Helpers\View;

function icon(string $name): string
{
    return Icon::getContent($name);
}

function view(string $path, array $params = []): string
{
    return View::getContent($path, $params);
}

function pluralize(string $singular): string
{
    return Text::pluralize($singular);
}

function singularize(string $plural): string
{
    return Text::singularize($plural);
}

function url(string $controller, string $action = ''): string
{
    return Route::getUrl($controller, $action);
}

function redirect(string $route, array $params = []): void
{
    Route::redirect($route, $params);
}

function dump($debug): void
{
    Debug::dump($debug);
}

function dd($debug): void
{
    Debug::dumpAndDie($debug);
}

function form(string $name, ?ModelInterface $model = null): string
{
    return Form::call($name, $model);
}
