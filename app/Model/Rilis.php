<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Rilis extends Model
{
    protected $table = 'rilis';

    protected $fillable = ['title', 'description', 'campaign_id', 'created_at', 'updated_at'];

    public function Campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }
}
