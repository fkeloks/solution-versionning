<?php

namespace ESGI\Core\Security;

class NotAllowedException extends \Exception
{
    protected $message = 'You do not have permission to perform this action.';
}
