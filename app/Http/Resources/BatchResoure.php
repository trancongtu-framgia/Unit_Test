<?php

namespace App\Http\Resources;

use App\Team;
use App\Type;
use App\Workspace;
use Illuminate\Http\Resources\Json\JsonResource;

class BatchResoure extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $workspace = Workspace::findOrFail($this->workspace_id);
        $team = Team::findOrFail($this->team_id);
        $type = Type::findOrFail($this->type_id);

        return [
            'id' => $this->id,
            'start_day' => $this->start_day,
            'stop_day' => $this->stop_day,
            'batch' => $this->batch,
            'workspace_id' => $this->workspace_id,
            'team_id' => $this->team_id,
            'type_id' => $this->type_id,
            'name' => $workspace->name . '-' . $team->name . '-' . $type->shorthand . '-' . $this->batch,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
