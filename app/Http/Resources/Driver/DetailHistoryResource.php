<?php

namespace App\Http\Resources\Driver;

use App\Model\Delivery;
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
        $delivery = Delivery::where('donasi_id', $this->id)->first();

        if (isset($delivery)) {
            $no_trx = $delivery->no_transaksi;
        } else {
            $no_trx = $this->no_transaksi;
        }

        return [
            'id' => $this->id,
            'status' => $this->status,
            'donatur' => $this->Users->name,
            'donatur_address' => $this->location,
            'donatur_long' => $this->long,
            'donatur_lat' => $this->lat,
            'campaigner' => $this->Campaign->Users->name,
            'campaigner_address' => $this->Campaign->location,
            'campaigner_long' => $this->Campaign->long,
            'campaigner_lat' => $this->Campaign->lat,
            'items' => ItemDonasiResource::collection($detail_donasi),
            'no_trx' => $no_trx,
        ];
    }
}
