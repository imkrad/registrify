<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'released_by','released_date','prepared_by','prepared_date','processed_by','processed_date','completed_by','completed_date','request_id'
    ];

    public function request()
    {
        return $this->belongsTo('App\Models\Request', 'request_id', 'id');
    }

    public function prepared()
    {
        return $this->belongsTo('App\Models\User', 'prepared_by', 'id');
    }

    public function processed()
    {
        return $this->belongsTo('App\Models\User', 'processed_by', 'id');
    }

    public function completed()
    {
        return $this->belongsTo('App\Models\User', 'completed_by', 'id');
    }

    public function released()
    {
        return $this->belongsTo('App\Models\User', 'released_by', 'id');
    }

    public function getPreparedDateAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getProcessedDateAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCompletedDateAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getReleasedDateAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

}
