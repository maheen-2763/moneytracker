<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->description,
            'amount'       => (float) $this->amount,
            'category'     => $this->category,
            'expense_date' => $this->expense_date,
            'created_at'   => $this->created_at->toDateTimeString(),
        ];
    }
}
