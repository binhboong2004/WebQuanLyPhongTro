<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminResponse extends Model
{
    protected $fillable = ['issue_id', 'admin_id', 'content'];

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
