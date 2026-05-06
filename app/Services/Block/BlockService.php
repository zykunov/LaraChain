<?php

namespace App\Services\Block;

use App\Entity\Block;
use App\Services\Chain\ChainService;
use App\Services\Chain\Storage\DatabaseStorage;

class BlockService
{

    private ChainService $chainService;
    private Hasher $hasher;

    private DatabaseStorage $storage;

    public function __construct(ChainService $chainService, Hasher $hasher, DatabaseStorage $storage)
    {
        $this->chainService = $chainService;
        $this->hasher = $hasher;
        $this->storage = $storage;
    }

    public function creatNewBlock(string $data): Block
    {
        $prevBlock =  $this->chainService->getLastBlock();

        $index = $prevBlock->getIndex() + 1 ;
        $prevHash = $prevBlock->getHash();

        $block = new Block($index, $prevHash, $data);

        $hash = $this->hasher->makeHash($block);
        $block->setHash($hash);

        return $block;
    }

    public function saveCurrentBlock(Block $block): Block
    {

        $block->

    }
}
