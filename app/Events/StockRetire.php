<?php

namespace App\Events;

use App\Models\MouvementStock;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockRetire
{
    use Dispatchable, SerializesModels;

    public function __construct(public readonly MouvementStock $mouvement)
    {
    }
}
