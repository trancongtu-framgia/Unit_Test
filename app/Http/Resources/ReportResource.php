<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
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
            'link' => $this->link,
            'test_link' => $this->test_link,
            'subject_id' => $this->subject_id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'email' => $this->email,
            'school' => $this->school
        ];
    }
}
