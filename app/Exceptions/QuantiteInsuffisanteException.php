<?php

namespace App\Exceptions;

use Exception;

class QuantiteInsuffisanteException extends Exception
{
    public function __construct(int $demande, int $disponible)
    {
        parent::__construct(
            "Impossible de retirer {$demande} unité(s) : seulement {$disponible} en stock."
        );
    }
}
