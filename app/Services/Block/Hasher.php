<?php

namespace App\Services\Block;

use App\Entity\Block;

class Hasher
{
    public function makeHash(Block $block): string
    {
        return hash(
            'sha256',
            $block->getHash() . $block->getIndex() . $block->getHash() . $block->getTimestamp()
        );
    }
}
