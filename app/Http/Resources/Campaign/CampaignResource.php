<?php

namespace App\Http\Resources\Campaign;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $time_limit = new DateTime($this->time_limit);
        $created_at = new DateTime($this->created_at);
        $now = new DateTime(Carbon::now());

        $day = $time_limit->diff($now);
        $limit = $time_limit->diff($created_at);
        $percent = 1 - $day->days / $limit->days;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => Str::limit((string) $this->description, 100),
            'image_url' => $this->path_image,
            'day' => $day->days,
            'percent' => $percent,
        ];
    }
}
