<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';

    public function Users()
    {
        return $this->hasMany(Users::class, 'role_id', 'id');
    }
}
