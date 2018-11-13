<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WeekScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $date = Carbon::now();
        $date->setDate($this->year, $this->month, $this->day);

        $status = config('api.status.short.' . $this->status);

        $data = [
            'id' => $this->id,
            'title' => $status,
            'start' => $date->toDateString(),
        ];

        return $data;
    }
}
