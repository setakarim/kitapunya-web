<?php

namespace App\Http\Resources\Donasi;

use Illuminate\Http\Resources\Json\JsonResource;

class DonaturResource extends JsonResource
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
        $donatur_name = '';
        $avatar_url = '';

        if ($this->anonim > 0) {
            $donatur_name = 'Anonim';
            $avatar_url = null;
        } else {
            $donatur_name = $this->Users->name;
            $avatar_url = $this->Users->path_photo;
        }

        return [
            'id' => $this->id,
            'name' => $donatur_name,
            'image_url' => $avatar_url,
            'barang' => DetailDonasiResource::collection($this->BarangCampaign),
        ];
    }
}
