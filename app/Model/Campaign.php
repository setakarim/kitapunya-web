<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'campaign';

    protected $fillable = ['no_transaksi', 'title', 'description', 'time_limit', 'file_name', 'location', 'long', 'lat', 'status',  'category_id', 'users_id', 'created_at', 'updated_at'];

    public function Category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function Users()
    {
        return $this->belongsTo(Users::class, 'users_id', 'id');
    }
}
