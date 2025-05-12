<?php

namespace App\Http\Controllers\API\V1\Finance\Operation;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Finance\Operation\FilterRequest;
use App\Http\Requests\API\V1\Finance\Operation\OperationRequest;
use App\Http\Resources\API\V1\Finance\OperationResource;
use App\Repositories\Finance\Operation\OperationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

abstract class OperationController extends Controller
{

    public function __construct(private readonly OperationRepository $operationRepository){}

    /**
     * Display a listing of the resource.
     */
    public function index(FilterRequest $request): JsonResponse
    {
        $operations = $this->operationRepository->getAll($request->toDto());
        return ApiResponse::success(OperationResource::collection($operations));
    }

    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     */
    public function store(OperationRequest $request): JsonResponse
    {
        $operation = $this->operationRepository->create($request->toDto());
        return ApiResponse::success(OperationResource::make($operation));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $operation = $this->operationRepository->getOne($id);
        return ApiResponse::success(OperationResource::make($operation));
    }

    /**
     * Update the specified resource in storage.
     * @throws ValidationException
     */
    public function update(OperationRequest $request, string $id): JsonResponse
    {
        $operation = $this->operationRepository->update($request->toDto(), $id);
        return ApiResponse::success(OperationResource::make($operation));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $this->operationRepository->delete($id);
        return ApiResponse::success(message: 'Запись удалена!');
    }

    public function summary(FilterRequest $request)
    {
        $operations = $this->operationRepository->summary($request->toDto());
        return ApiResponse::success($operations);
    }
}
