<?php

namespace App\Services\Chain\Storage;

use App\Entity\Chain;

interface StorageInterface
{
    public function saveChainWithBlocks(Chain $chain): bool;

    public function get(): Chain;

    public function getBlocks(int $chainId): array;


}
