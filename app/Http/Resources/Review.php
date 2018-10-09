<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Review extends JsonResource
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
            'content' => $this->content,
            'user_id' => $this->user_id,
            'report_id' => $this->report_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
