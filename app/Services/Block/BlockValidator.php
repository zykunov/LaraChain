<?php

namespace App\Services\Block;

use App\Models\Block;

class BlockValidator
{
    private Hasher $hasher;

    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    public function validate(Block $oldBlock, Block $newBlock): bool
    {
        if ($oldBlock->getHashAttribute() !== $newBlock->getPreviousHashAttribute()) {
            return false;
        }

        if ($oldBlock->getIndexAttribute() + 1 !== $newBlock->getIndexAttribute()) {
            return false;
        }

        if ($this->hasher->makeHash($newBlock) !== $newBlock->getHashAttribute()) {
            return false;
        }

        return true;

    }
}
