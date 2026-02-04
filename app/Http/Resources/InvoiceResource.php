<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $paidAmount = $this->payments_sum_amount ?? $this->payments->sum('amount');
        $totalAmount = (float) $this->total_amount;

        return [
            'id' => $this->id,
            'membership_id' => $this->membership_id,
            'number' => $this->number,
            'total_amount' => number_format($totalAmount, 2, '.', ''),
            'paid_amount' => number_format((float) $paidAmount, 2, '.', ''),
            'remaining_balance' => number_format($totalAmount - $paidAmount, 2, '.', ''),
            'status' => $this->status,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),

            // Conditional relationships
            'membership' => new MembershipResource($this->whenLoaded('membership')),
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
        ];
    }
}
