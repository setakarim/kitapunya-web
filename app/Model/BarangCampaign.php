<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BarangCampaign extends Model
{
    protected $table = 'barang_campaign';

    protected $fillable = ['max_qty', 'real_qty', 'barang_id', 'campaign_id', 'created_at', 'updated_at'];

    public function Barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }

    public function Campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }
}
