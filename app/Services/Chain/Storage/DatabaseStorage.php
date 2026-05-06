<?php

namespace App\Services\Chain\Storage;

use App\Models\Block;
use App\Models\Chain as EloquentChain;
use App\Entity\Chain as EntityChain;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseStorage implements StorageInterface
{
    /**
     * Сохранить цепочку в БД
     * Если запись уже есть (с ID), обновит её, иначе создаст новую
     *
     * @param Chain $chain
     * @return bool
     */

    public function saveChainWithBlocks(EntityChain $entityChain): bool
    {
        try {
            DB::beginTransaction();

            // Создаём запись цепи
            $chain = new EloquentChain();
            $chain->save();

            // Сохраняем все блоки
            foreach ($entityChain->getBlocks() as $block) {
                $eloquentBlock = new Block([
                    'chain_id' => $chain->id,
                    'index' => $block->getIndex(),
                    'data' => $block->getData(),
                    'timestamp' => $block->getTimestamp(),
                    'previous_hash' => $block->getPreviousHash(),
                    'hash' => $block->getHash(),
                    ''
                ]);
                $eloquentBlock->save();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving chain with blocks: ' . $e->getMessage());
            return false;
        }
    }

    /**
     *
     * @return Chain
     */
    public function get(): EntityChain
    {
        // Получаем последнюю добавленную цепочку (по ID)
        return Chain::orderBy('id', 'desc')->first();
    }
}
