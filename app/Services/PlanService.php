<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Collection;

class PlanService
{
    /**
     * Get all plans.
     */
    public function getAllPlans(): Collection
    {
        return Plan::all();
    }

    /**
     * Get a single plan.
     */
    public function getPlan(Plan $plan): Plan
    {
        return $plan;
    }

    /**
     * Create a new plan.
     */
    public function createPlan(array $data): Plan
    {
        return Plan::create($data);
    }

    /**
     * Update an existing plan.
     */
    public function updatePlan(Plan $plan, array $data): Plan
    {
        $plan->update($data);
        return $plan->fresh();
    }

    /**
     * Delete a plan.
     */
    public function deletePlan(Plan $plan): bool
    {
        return $plan->delete();
    }
}
