<?php

namespace App\Http\Resources\DonaturHistory;

use App\Http\Resources\Donasi\DetailDonasiResource;
use App\Model\DetailDonasi;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailHistoryResource extends JsonResource
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
            'title' => $this->Campaign->title,
            'no_trx' => $this->no_transaksi,
            'campaigner' => $this->Users->name,
            'status' => $this->status,
            'date' => $this->created_at->formatLocalized('%d %B %Y'),
            'address' => $this->location,
            'items' => DetailDonasiResource::collection($detail_donasi),
        ];
    }
}
