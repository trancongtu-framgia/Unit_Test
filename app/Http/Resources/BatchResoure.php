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
        return [
            'id' => $this->id,
            'start_day' => $this->start_day,
            'stop_day' => $this->stop_day,
            'batch' => $this->batch,
            'workspace' => $this->workspace->name,
            'team' => $this->team->name,
            'type' => $this->type->name,
            'name' => $this->nameBatch(),
            'subjects' => $this->subjects,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function nameBatch ()
    {
        return $this->workspace->name . '-' . $this->team->name . '-' . $this->type->shorthand . '-' . $this->batch;
    }
}
