<?php

namespace App\Http\Resources;

use App\Role;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Batch;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'school' => $this->school,
            'role' => Role::findOrFail($this->role_id)->name,
            'batch_id' => $this->batch_id
        ];
    }
}
