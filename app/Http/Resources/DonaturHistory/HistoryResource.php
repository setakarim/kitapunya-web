<?php

namespace App\Http\Resources\DonaturHistory;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
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
        return [
            'id' => $this->id,
            'title' => $this->Campaign->title,
            'status' => $this->status,
            'date' => $this->created_at->formatLocalized('%d %B %Y'),
        ];
    }
}
