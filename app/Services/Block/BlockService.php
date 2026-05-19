<?php

namespace App\Services\Block;

use App\Entity\Block;
use App\Services\Chain\ChainService;
use App\Services\Chain\Storage\DatabaseStorage;
use Illuminate\Http\Request;

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

    public function createNewBlock(Request $request): Block
    {

        $request->validate([
            'data' => 'required|string',
        ]);

        $prevBlock =  $this->chainService->getLastBlock();

        $index = $prevBlock->getIndex() + 1 ;
        $prevHash = $prevBlock->getHash();

        $block = new Block($index, $prevHash, $data);

        $hash = $this->hasher->makeHash($block);
        $block->setHash($hash);

        dd(1);

        return $block;
    }

    public function getBlocks(int $chainId): array
    {
        return \App\Models\Block::where('chain_id', $chainId)->get()->toArray();
    }

    public function saveCurrentBlock(Block $block): Block
    {

    }
}
