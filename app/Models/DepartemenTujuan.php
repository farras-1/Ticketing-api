<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model\Relations\Hasmany;

class DepartemenTujuan extends Model
{
    protected $table = 'departemen_tujuans';
    protected $guarded = ['id'];

    public function tickets(): Hasmany {
        return $this->Hasmany(Ticket::class, 'departemen_id');
    }
}
