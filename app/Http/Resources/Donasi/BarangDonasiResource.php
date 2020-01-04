<?php

namespace App\Http\Resources\Donasi;

use Illuminate\Http\Resources\Json\JsonResource;

class BarangDonasiResource extends JsonResource
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
            'name' => $this->Barang->name,
            'real_qty' => $this->real_qty,
            'max_qty' => $this->max_qty,
        ];
    }
}
