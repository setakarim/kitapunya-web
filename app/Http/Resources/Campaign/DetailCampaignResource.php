<?php

namespace App\Http\Resources\Campaign;

use App\Http\Resources\Donasi\BarangDonasiResource;
use App\Http\Resources\Donasi\DonaturResource;
use App\Model\BarangCampaign;
use App\Model\Donasi;
use App\Model\Rilis;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailCampaignResource extends JsonResource
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

        $rilis = Rilis::where('campaign_id', $this->id)->first();
        $barang = BarangCampaign::where('campaign_id', $this->id)->get();
        $donatur = Donasi::where('campaign_id', $this->id)->get();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image_url' => $this->file_name,
            'day' => $day->days,
            'percent' => $percent,
            'campaigner' => $this->Users->name,
            'barang' => BarangDonasiResource::collection($barang),
            'donatur' => DonaturResource::collection($donatur),
            'rilis' => $rilis['description'],
        ];
    }
}
