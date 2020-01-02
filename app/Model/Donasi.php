<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    protected $table = 'donasi';

    protected $fillable = ['no_transaksi', 'status', 'location', 'long', 'lat', 'anonim', 'users_id', 'campaign_id', 'created_at', 'updated_at'];

    public function Campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }

    public function Users()
    {
        return $this->belongsTo(Users::class, 'users_id', 'id');
    }
}
