<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'code','user_id','type_id','status_id','due_at','claimed_at','is_express','is_personal'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'type_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id');
    }

    public function lists()
    {
        return $this->hasMany('App\Models\RequestList', 'request_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\RequestComment', 'request_id')->orderBy('created_at','DESC');
    }

    public function payment()
    {
        return $this->hasOne('App\Models\RequestPayment', 'request_id');
    }

    public function authorization()
    {
        return $this->hasOne('App\Models\RequestAuthorization', 'request_id');
    }

    public function log()
    {
        return $this->hasOne('App\Models\RequestLog', 'request_id');
    }

    public function attachments()
    {
        return $this->hasMany('App\Models\RequestAttachment', 'request_id');
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getDueAtAttribute($value)
    {
        return date('M d, Y', strtotime($value));
    }

    public function getClaimedAtAttribute($value)
    {
        return ($value) ? date('M d, Y g:i a', strtotime($value)) : '-';
    }
}
