<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onsite extends Model
{
    use HasFactory;

    protected $fillable = [
        'code','name','total','year','user_id','status_id','claimed_at',
    ];

    public function lists()
    {
        return $this->hasMany('App\Models\OnsiteDocument', 'onsite_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id');
    }


    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    public function setYearAttribute($value)
    {
        $this->attributes['year'] = strtoupper($value);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getClaimedAtAttribute($value)
    {
        return ($value) ? date('M d, Y g:i a', strtotime($value)) : '-';
    }
}
