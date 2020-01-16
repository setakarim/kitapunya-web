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
        $avatar_url = null;

        if ($this->anonim > 0) {
            $donatur_name = 'Anonim';
        } else {
            $donatur_name = $this->Users->name;
            if ($this->Users->file_name != null) {
                // $avatar_url = 'http://192.168.1.23:8000/uploads/profile/'.$this->Users->file_name;
                $avatar_url = 'http://kitapunya.setakarim.xyz/uploads/profile/'.$this->Users->file_name;
            }
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
