<?php

namespace ESGI\Controllers;

class TemporaryController extends Controller
{
    public function componentsAction(): void
    {
        $this->render('tmp.components', 'backend');
    }
}
