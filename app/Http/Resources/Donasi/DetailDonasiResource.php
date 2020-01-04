<?php

namespace App\Http\Resources\Donasi;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailDonasiResource extends JsonResource
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
            'name' => $this->BarangCampaign->Barang->name,
            'qty' => $this->qty,
        ];
    }
}
