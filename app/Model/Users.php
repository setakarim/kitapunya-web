<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Users extends Model
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password', 'role_id'];
    protected $hidden = ['password', 'remember_token'];

    protected $appends = ['role_name'];

    public function Role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function getRoleNameAttribute()
    {
        return $this->Role->name;
    }
}
