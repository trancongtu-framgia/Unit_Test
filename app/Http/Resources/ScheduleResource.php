<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
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

        $status = null;
        $className = null;

        switch ($this->status) {
            case 0: {
                $status = config('api.status.' . $this->status);
                break;
            }
            case 1: {
                $status = config('api.status.' . $this->status);
                $className = 'm-fc-event--solid-success';
                break;
            }
            case 2: {
                $status = config('api.status.' . $this->status);
                $className = 'm-fc-event--solid-primary';
                break;
            }
            case 3: {
                $status = config('api.status.' . $this->status);
                $className = 'm-fc-event--solid-warning';
                break;
            }
        }

        return [
            'id' => $this->id,
            'title' => $status,
            'start' => $date->toDateString(),
            'className' => $className,
            'dayofweek' => $this->dayofweek,
            'month' => $this->month,
            'year' => $this->year,
            'user_id' => $this->user_id
        ];
    }
}