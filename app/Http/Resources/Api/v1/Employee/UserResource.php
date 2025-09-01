<?php

namespace App\Http\Resources\Api\v1\Employee;


use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                            => $this->id,
            'name'                          => $this->name,
            'phone'                         => $this->phone,
            'photo'                         => $this->photo ? asset('upload/admin_image/' . $this->photo) : null,
            'email'                         => $this->email,
            'job_title'                     => $this->job_title,
            'company'                       => new CompanyResource($this->company),
            'department'                    => new DepartmentResource($this->department),
            'team'                          => new TeamResource($this->team),
            'role'                          => $this->role,
            'is_manager'                    => $this->is_manager,
            'created_at'                    => $this->created_at,
            'updated_at'                    => $this->updated_at,
        ];
    }
}
