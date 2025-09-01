<?php

namespace App\Http\Resources\Api\v1\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class CashRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                                => $this->id,
            'request_name'                      => $this->request_name,
            'reason'                            => $this->reason,
            'request_date'                      => $this->request_date,
            'due_date'                          => $this->due_date,
            'amount'                            => $this->amount,
            'user'                              => new UserResource($this->user),
//            'cashCategory'                      => new CashCategoryResource($this->cashCategory),
            'status'                            => $this->status,
            'approved_by_manager'               => $this->approved_by_manager,
            'approved_by_accounts'              => $this->approved_by_accounts,
            'approved_by_gm'                    => $this->approved_by_gm,
            'attachment'                        => $this->photo ? asset('upload/admin_image/' . $this->photo) : null,
            'created_at'                        => $this->created_at,
            'updated_at'                        => $this->updated_at,
        ];
    }
}
