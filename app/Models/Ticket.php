<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['event_id', 'code', 'purchase_id'];

    // En el modelo Ticket
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
}
