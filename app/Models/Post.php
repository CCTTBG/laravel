<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = ['name','comment','email','is_notice','notice_start_at','notice_end_at'];
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
