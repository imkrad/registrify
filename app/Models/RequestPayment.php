<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'total','status_id','request_id','user_id','or_number'
    ];

    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id');
    }

    public function request()
    {
        return $this->belongsTo('App\Models\Request', 'request_id', 'id');
    }

    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = trim(str_replace(',','',$value),'₱');
    }

    public function getTotalAttribute($value)
    {
        return '₱'.number_format($value,2,'.',',');
    }
}
