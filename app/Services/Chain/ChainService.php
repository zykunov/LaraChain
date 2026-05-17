<?php

namespace App\Services\Chain;

use App\Models\Block;
use App\Models\Chain;
use Illuminate\Database\Eloquent\Collection;

class ChainService
{
    private ChainValidator $chainValidator;

    public function __construct(ChainValidator $chainValidator)
    {
        $this->chainValidator = $chainValidator;
    }

    public function getChains(): Collection
    {
        return Chain::all();
    }

    public function checkChain(int $chainId): bool
    {
        return Chain::where('id', $chainId)->exists();
    }

    public function getCurrentChain(): Chain
    {

    }

    public function saveCurrentChain(Chain $chain): void
    {


    }


}
