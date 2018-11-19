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
        $data = [
            'id' => $this->id,
            'avatar' => $this->avatar != null ? $this->avatar : config('api.default.avatar'),
            'name' => $this->name,
            'email' => $this->email,
            'school' => $this->school,
            'role' => Role::findOrFail($this->role_id)->name,
        ];
        if ($this->batch_id) {
            $batch = Batch::findOrFail($this->batch_id);
            $data = array_merge($data, [
                'batch_id' => $this->batch_id,
                'batch' => $this->nameBatch($batch),
            ]);
        }

        return $data;
    }

    public function nameBatch($batch)
    {
        return $batch->workspace->name . '-' . $batch->team->name . '-' . $batch->type->shorthand . '-' . $batch->batch;
    }
}
