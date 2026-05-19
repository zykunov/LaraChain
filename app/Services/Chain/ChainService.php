<?php

namespace App\Services\Chain;

use App\Models\Chain;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class ChainService
{
    private ChainValidator $chainValidator;

    public function __construct(ChainValidator $chainValidator)
    {
        $this->chainValidator = $chainValidator;
    }

    public function getChains(): Collection
    {
        $cacheKey = 'chains:all';

        return Cache::remember($cacheKey, 120, function () {
            return Chain::all();
        });
    }

    public function checkChain(int $chainId): bool
    {
        $cacheKey = 'chain:exists:' . $chainId;

        return Cache::remember($cacheKey, 120, function () use ($chainId) {
            return Chain::where('id', $chainId)->exists();
        });
    }

    /**
     * Очищает кэш для всех цепочек и конкретной цепочки по ID
     */
    public function invalidateCache(?int $chainId = null): void
    {
        if ($chainId !== null) {
            Cache::forget('chain:exists:' . $chainId);
        }

        Cache::forget('chains:all');
    }
}
