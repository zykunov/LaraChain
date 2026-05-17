<?php

namespace App\Http\Controllers;

use App\Models\Chain;
use App\Services\Block\BlockService;
use App\Services\Chain\ChainService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlockchainController
{
    private ChainService $chainService;
    private BlockService $blockService;

    /**
     * @param ChainService $chainService
     * @param BlockService $blockService
     */
    public function __construct(
        ChainService $chainService,
        BlockService $blockService,
    )
    {
        $this->chainService = $chainService;
        $this->blockService = $blockService;
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
//        $currentChain = $this->chainService->appendNewBlock($newBlock);
//        $this->chainService->saveCurrentChain($currentChain);

        return response()->json(['success' => true], 201);
    }

    public function show(): JsonResponse
    {
        $response = $this->chainService->getCurrentChain();

        return response()->json($response);
    }

    /**
     * Получение всех цепочек
     * @return JsonResponse
     */
    public function allChains(): JsonResponse
    {
        return response()->json($this->chainService->getChains());
    }

    /**
     * Получение цепочки по id
     * @param $id
     * @return JsonResponse
     */
    public function getBlocksByChainId(string|int $id): JsonResponse
    {
        $chainId = (int) $id;

        if ($chainId <= 0) {
            return response()->json([
                'error' => 'ID цепочки должен быть положительным целым числом'
            ], 400);
        }

        $blocks = $this->blockService->getBlocks($chainId);
        return response()->json($blocks);
    }

    public function addBlock(Request $request): JsonResponse
    {
        $validator = \Validator::make($request->all(), [
            'data' => 'required|string',
            'chainId' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка валидации данных',
                'errors' => $validator->errors()->toArray(),
                'timestamp' => now()->toIso8601String(),
            ], 422);
        }

        if (!$this->chainService->checkChain($request->input('chainId'))) {
            return response()->json(['error' => "Цепи с указанным id не существует"]);
        }

        $block = $this->blockService->createNewBlock($request);

        return response()->json(['success' => true, 'block' => $block], 201);

    }
}

