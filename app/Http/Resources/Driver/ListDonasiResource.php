<?php

namespace App\Http\Resources\Driver;

use App\Model\DetailDonasi;
use Illuminate\Http\Resources\Json\JsonResource;

class ListDonasiResource extends JsonResource
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
        $detail_donasi = DetailDonasi::where('donasi_id', $this->id)->get();

        return [
            'id' => $this->id,
            'status' => $this->status,
            'items' => ItemDonasiResource::collection($detail_donasi),
        ];
    }
}
