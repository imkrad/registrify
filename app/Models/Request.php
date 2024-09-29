<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id','type_id','status_id','due_at','claimed_at'
    ];

    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id', 'id');
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

    public function payment()
    {
        return $this->hasOne('App\Models\RequestPayment', 'request_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
