<?php

namespace App\Services\Block;

use App\Models\Block;


class Hasher
{
    public function makeHash(Block $block): string
    {

        return hash(
            'sha256',
            $block->getTimestampAttribute() . $block->getPreviousHashAttribute()
        );
    }
}
