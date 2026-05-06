<?php

namespace App\Services\Block;

use App\Entity\Block;

class BlockValidator
{
    private Hasher $hasher;

    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    public function validate(Block $oldBlock, Block $newBlock): bool
    {
        if ($oldBlock->getHash() !== $newBlock->getPreviousHash()) {
            return false;
        }

        if ($oldBlock->getIndex() + 1 !== $newBlock->getIndex()) {
            return false;
        }

        if ($this->hasher->makeHash($newBlock) !== $newBlock->getHash()) {
            return false;
        }

        return true;

    }
}
