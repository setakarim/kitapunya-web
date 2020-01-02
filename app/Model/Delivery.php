<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'delivery';

    protected $fillable = ['no_transaksi', 'donasi_id', 'users_id', 'created_at', 'updated_at'];

    public function Donasi()
    {
        return $this->belongsTo(Donasi::class, 'donasi_id', 'id');
    }

    public function Users()
    {
        return $this->belongsTo(Users::class, 'users_id', 'id');
    }
}
