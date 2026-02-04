<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use App\Services\MemberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function __construct(
        protected MemberService $memberService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Member::class);

        $search = $request->query('search');
        $members = $this->memberService->getMembers($search);

        return response()->json([
            'success' => true,
            'data' => MemberResource::collection($members->items()),
            'meta' => [
                'current_page' => $members->currentPage(),
                'last_page' => $members->lastPage(),
                'per_page' => $members->perPage(),
                'total' => $members->total(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MemberRequest $request): JsonResponse
    {
        $this->authorize('create', Member::class);

        $member = $this->memberService->createMember($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Member created successfully',
            'data' => new MemberResource($member),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member): JsonResponse
    {
        $this->authorize('view', $member);

        $member = $this->memberService->getMember($member);

        return response()->json([
            'success' => true,
            'data' => new MemberResource($member),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MemberRequest $request, Member $member): JsonResponse
    {
        $this->authorize('update', $member);

        $member = $this->memberService->updateMember($member, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Member updated successfully',
            'data' => new MemberResource($member),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member): JsonResponse
    {
        $this->authorize('delete', $member);

        $this->memberService->deleteMember($member);

        return response()->json([
            'success' => true,
            'message' => 'Member deleted successfully',
        ]);
    }
}
