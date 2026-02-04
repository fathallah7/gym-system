<?php

namespace App\Http\Controllers;

use App\Http\Requests\MembershipRequest;
use App\Http\Resources\MembershipResource;
use App\Models\Membership;
use App\Services\MembershipService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function __construct(
        protected MembershipService $membershipService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Membership::class);

        $search = $request->query('search');
        $memberships = $this->membershipService->getMemberships($search);

        return response()->json([
            'success' => true,
            'data' => MembershipResource::collection($memberships->items()),
            'meta' => [
                'current_page' => $memberships->currentPage(),
                'last_page' => $memberships->lastPage(),
                'per_page' => $memberships->perPage(),
                'total' => $memberships->total(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MembershipRequest $request): JsonResponse
    {
        $this->authorize('create', Membership::class);

        try {
            $membership = $this->membershipService->createMembership($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Membership, Payment, and Invoice created successfully',
                'data' => new MembershipResource($membership),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create membership, payment, or invoice',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Membership $membership): JsonResponse
    {
        $this->authorize('view', $membership);

        $membership = $this->membershipService->getMembership($membership);

        return response()->json([
            'success' => true,
            'data' => new MembershipResource($membership),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MembershipRequest $request, Membership $membership): JsonResponse
    {
        $this->authorize('update', $membership);

        $membership = $this->membershipService->updateMembership($membership, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Membership updated successfully',
            'data' => new MembershipResource($membership),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Membership $membership): JsonResponse
    {
        $this->authorize('delete', $membership);

        $this->membershipService->deleteMembership($membership);

        return response()->json([
            'success' => true,
            'message' => 'Membership deleted successfully',
        ]);
    }
}
