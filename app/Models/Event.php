<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name', 'description', 'qty', 'available_qty', 'version', 'from', 'until'];

    public function updateAvailableQty(int $qty)
    {
        $this->available_qty -= $qty;
        return $this->save();
    }

    public function scopeUpcoming($query, $date = null)
    {
        $date = $date ?: Carbon::now();

        return $query
            ->where('from', '<=', $date)
            ->where('until', '>=', $date);
    }
}
