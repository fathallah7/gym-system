<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanRequest;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use App\Services\PlanService;
use Illuminate\Http\JsonResponse;

class PlanController extends Controller
{
    public function __construct(
        protected PlanService $planService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Plan::class);

        $plans = $this->planService->getAllPlans();

        return response()->json([
            'success' => true,
            'message' => 'Plans retrieved successfully',
            'data' => PlanResource::collection($plans),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanRequest $request): JsonResponse
    {
        $this->authorize('create', Plan::class);

        $plan = $this->planService->createPlan($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Plan created successfully',
            'data' => new PlanResource($plan),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan): JsonResponse
    {
        $this->authorize('view', $plan);

        $plan = $this->planService->getPlan($plan);

        return response()->json([
            'success' => true,
            'data' => new PlanResource($plan),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanRequest $request, Plan $plan): JsonResponse
    {
        $this->authorize('update', $plan);

        $plan = $this->planService->updatePlan($plan, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Plan updated successfully',
            'data' => new PlanResource($plan),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan): JsonResponse
    {
        $this->authorize('delete', $plan);

        $this->planService->deletePlan($plan);

        return response()->json([
            'success' => true,
            'message' => 'Plan deleted successfully',
        ]);
    }
}
