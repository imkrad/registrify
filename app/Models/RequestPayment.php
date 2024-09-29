<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPayment extends Model
{
    use HasFactory;

    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id');
    }

    public function request()
    {
        return $this->belongsTo('App\Models\Request', 'request_id', 'id');
    }
}
