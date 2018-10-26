<?php

namespace App\Http\Resources;

use App\Role;
use App\Team;
use App\Type;
use App\Batch;
use App\Workspace;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $batch = Batch::findOrFail($this->batch_id);
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'school' => $this->school,
            'role' => Role::findOrFail($this->role_id)->name,
            'batch' => $batch->batch,
            'workspace' => Workspace::findOrFail($batch->workspace_id)->name,
            'team' => Team::findOrFail($batch->team_id)->name,
            'type' => Type::findOrFail($batch->type_id)->name,
        ];
    }
}
