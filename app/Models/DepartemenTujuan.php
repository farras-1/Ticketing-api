<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DepartemenTujuan extends Model
{
    protected $table = 'departemen_tujuans';
    protected $guarded = ['id'];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'departemen_id');
    }
}
