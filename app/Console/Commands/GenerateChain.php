<?php

namespace App\Console\Commands;

use App\Entity\Block;
use App\Entity\Chain;
use App\Services\Block\BlockService;
use App\Services\Block\Hasher;
use App\Services\Chain\ChainService;

use Illuminate\Console\Command;

class GenerateChain extends Command
{
    /** @var string $signature */
    protected $signature = 'generate:blockchain_with_genesis_block';

    /** @var string $description */
    protected $description = 'Create new blockchain with genesis block.';

    private ChainService $chainService;
    private Hasher $blockHasher;

    /**
     * @param ChainService $chainService
     * @param Hasher $blockHasher
     */
    public function __construct(ChainService $chainService, Hasher $blockHasher)
    {
        parent::__construct();

        $this->chainService = $chainService;
        $this->blockHasher = $blockHasher;
    }

    public function handle(): void
    {

        //TODO сделать проверку на существования init блока
        $initBlock = new Block(index: 0, previousHash: '', data: 'init block');

        $hash = $this->blockHasher->makeHash($initBlock);
        $initBlock->setHash($hash);

        $chain = new Chain([$initBlock]);

        $this->chainService->saveCurrentChain($chain);


    }

}
