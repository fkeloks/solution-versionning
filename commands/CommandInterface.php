<?php

namespace ESGI\Commands;

interface CommandInterface
{
    /**
     * Execute la commande
     *
     * @param array $arguments
     */
    public static function process(array $arguments): void;
}
