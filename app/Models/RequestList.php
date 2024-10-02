<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestList extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity','fee','total','status_id','document_id','request_id','user_id'
    ];

    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id');
    }

    public function document()
    {
        return $this->belongsTo('App\Models\Document', 'document_id', 'id');
    }

    public function request()
    {
        return $this->belongsTo('App\Models\Request', 'request_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = trim(str_replace(',','',$value),'₱');
    }

    public function getTotalAttribute($value)
    {
        return '₱'.number_format($value,2,'.',',');
    }

    public function setFeeAttribute($value)
    {
        $this->attributes['fee'] = trim(str_replace(',','',$value),'₱');
    }

    public function getFeeAttribute($value)
    {
        return '₱'.number_format($value,2,'.',',');
    }
}
