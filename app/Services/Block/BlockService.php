<?php

namespace App\Services\Block;

use App\Models\Block;
use App\Services\Chain\ChainService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

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

        // 2. При создании нового блока принудительно удаляем кэш для этой цепочки
        // чтобы при следующем запросе getBlocks/getLastBlock получили актуальные данные
        $this->invalidateCache($chainId);

        $prevBlock = $this->getLastBlock($chainId);
        $prevHash = $prevBlock->getHashAttribute();

        $block = new Block([
            'chain_id' => $chainId,
            'data' => $data,
            'previous_hash' => $prevHash,
            'timestamp' => time(),
        ]);

        $block->hash = $this->hasher->makeHash($block);
        $block->save();

        return $block;
    }

    public function getBlocks(string|int $chainId): Collection
    {
        $cacheKey = 'blocks:' . $chainId;

        // Пытаемся получить данные из кэша. Если нет — сохраняем результат запроса в кэш на 1 минуту
        return Cache::remember($cacheKey, 60, function () use ($chainId) {
            return Block::where('chain_id', $chainId)
                ->orderBy('id', 'asc')
                ->get();
        });
    }

    public function getLastBlock(int $chainId): Block
    {
        $cacheKey = 'last_block:' . $chainId;

        return Cache::remember($cacheKey, 60, function () use ($chainId) {
            return Block::where('chain_id', $chainId)
                ->orderBy('id', 'desc')
                ->firstOrFail();
        });
    }

    private function invalidateCache(int $chainId): void
    {
        Cache::forget('blocks:' . $chainId);
        Cache::forget('last_block:' . $chainId);
    }
}
