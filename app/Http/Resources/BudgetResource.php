<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BudgetResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'category'      => $this->category,
            'amount'        => (float) $this->amount,
            'spent'         => (float) $this->spentThisMonth(),
            'remaining'     => (float) max(0, $this->amount - $this->spentThisMonth()),
            'percent_used'  => $this->percentUsed(),
            'status'        => $this->status(),
        ];
    }
}
