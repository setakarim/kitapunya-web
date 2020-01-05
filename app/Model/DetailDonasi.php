<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DetailDonasi extends Model
{
    protected $table = 'detail_donasi';

    protected $fillable = ['qty', 'file_name', 'donasi_id', 'barang_campaign_id', 'created_at', 'updated_at'];

    public function Donasi()
    {
        return $this->belongsTo(Donasi::class, 'donasi_id', 'id');
    }

    public function BarangCampaign()
    {
        return $this->belongsTo(BarangCampaign::class, 'barang_campaign_id', 'id');
    }
}
