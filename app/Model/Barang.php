<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = ['name', 'created_at', 'updated_at'];
}
