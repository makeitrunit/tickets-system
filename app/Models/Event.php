<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name', 'description', 'qty', 'available_qty', 'version'];

    public function updateAvailableQty(int $qty)
    {
        $this->available_qty -= $qty;
        return $this->save();
    }
}
