<?php

namespace App\Services\Block;

use App\Models\Block;
use App\Services\Chain\ChainService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class BlockService
{

    private ChainService $chainService;
    private Hasher $hasher;


    public function __construct(ChainService $chainService, Hasher $hasher)
    {
        $this->chainService = $chainService;
        $this->hasher = $hasher;
    }

    public function createNewBlock(Request $request): Block
    {

        $data = $request->input('data');
        $chainId = $request->input('chainId');

        $prevBlock = $this->getLastBlock($chainId);
        $prevHash = $prevBlock->getHashAttribute();

        $block = new Block([
            'chain_id' => $chainId,
            'data' => $data,
            'previous_hash' => $prevHash,
            'timestamp' => time(),
        ]);

        $block->hash = $this->hasher->makeHash($block);

        // Сохраняем блок в базу данных
        $block->save();

        return $block;
    }


    public function getBlocks(string|int $chainId): Collection
    {
        return Block::where('chain_id', $chainId)
            ->orderBy('id', 'asc')
            ->get();
    }

    public function getLastBlock(int $chainId): Block
    {
        return Block::where('chain_id', $chainId)
            ->orderBy('id', 'desc')
            ->firstOrFail();
    }

    public function saveCurrentBlock(Block $block): Block
    {

    }
}
