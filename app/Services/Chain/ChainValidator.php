<?php

namespace App\Services\Chain;

use App\Models\Chain;
use App\Services\Block\BlockValidator;

class ChainValidator
{
    private BlockValidator $blockValidator;

    public function __construct(BlockValidator $blockValidator)
    {
        $this->blockValidator = $blockValidator;
    }

    public function validate(Chain $chain)
    {
        $blocks = $chain->getBlocksAttribute();


        for ($i = 1; $i < count($blocks); $i++) {
            if (!$this->blockValidator->validate($blocks[$i-1], $blocks[$i])) {
                return false;
            }
        }
        return true;
    }
}
