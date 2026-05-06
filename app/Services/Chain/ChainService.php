<?php

namespace App\Services\Chain;

use App\Entity\Block;
use App\Entity\Chain;
use App\Services\Chain\Storage\BDStorage;
use App\Services\Chain\Storage\DatabaseStorage;

class ChainService
{
    private ChainValidator $chainValidator;
    private DatabaseStorage $storage;

    public function __construct(ChainValidator $chainValidator, DatabaseStorage $storage)
    {
        $this->chainValidator = $chainValidator;
        $this->storage = $storage;
    }

    public function addNewBlock(Block $block): Chain
    {
        $currentChain = $this->getCurrentChain();

        $blocks = $currentChain->getBlocks();
        $blocks[] = $block;

        return $currentChain->update($blocks);
    }

    public function getCurrentChain(): Chain
    {
        return $this->storage->get();
    }

    public function saveCurrentChain(Chain $chain): void
    {
        $isChainValid = $this->chainValidator->validate($chain);

        if (!$isChainValid) {
            throw new \Exception("chain validation failed");
            //TODO: мб добавить логи или json для api
        }

        $this->storage->saveChainWithBlocks($chain);

    }

    public function getLastBlock(): Block
    {
        $blocks = $this->getCurrentChain()->getBlocks();

        return end($blocks);
    }

}
