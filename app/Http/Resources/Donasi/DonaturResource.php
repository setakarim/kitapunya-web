<?php

namespace App\Http\Resources\Donasi;

use App\Model\DetailDonasi;
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

        $detail_donasi = DetailDonasi::where('donasi_id', $this->id)->get();

        return [
            'id' => $this->id,
            'name' => $donatur_name,
            'image_url' => $avatar_url,
            'barang' => DetailDonasiResource::collection($detail_donasi),
        ];
    }
}
