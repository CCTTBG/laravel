<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rank extends Model
{
    //
   public function users()
{
    return $this->hasMany(User::class);
}

}
