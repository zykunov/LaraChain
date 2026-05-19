<?php

namespace App\Http\Controllers;

use App\Models\Chain;
use App\Services\Block\BlockService;
use App\Services\Chain\ChainService;
use App\Services\Chain\ChainHydrator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlockchainController
{
    private ChainService $chainService;
    private BlockService $blockService;
    private ChainHydrator $chainHydrator;

    /**
     * @param ChainService $chainService
     * @param BlockService $blockService
     */
    public function __construct(ChainService $chainService, BlockService $blockService, ChainHydrator $chainHydrator)
    {
        $this->chainService = $chainService;
        $this->blockService = $blockService;
        $this->chainHydrator = $chainHydrator;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        $data = $request->input('data');

        $newBlock = $this->blockService->createNewBlock($data);
        $currentChain = $this->chainService->appendNewBlock($newBlock);
        $this->chainService->saveCurrentChain($currentChain);

        return response()->json(['success' => true], 201);
    }

    public function show(): JsonResponse
    {
        $currentChain = $this->chainService->getCurrentChain();
        $response = $this->chainHydrator->extract($currentChain);

        return response()->json(['chain' => $response]);
    }

    public function allChains(): JsonResponse
    {
        $chains = Chain::all();
        return response()->json($chains);
    }

    public function showChain($id): JsonResponse
    {
        $chain = $this->blockService->getBlocks($id);
        return response()->json($chain);
    }
}

