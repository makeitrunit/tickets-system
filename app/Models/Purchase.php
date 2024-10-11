<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['user_id', 'event_id', 'qty', 'status'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'purchase_id');
    }
}
