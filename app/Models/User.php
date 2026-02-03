<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'phone', 'role', 'avatar'];
    protected $hidden = ['password', 'remember_token'];

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'tenant_id');
    }
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
