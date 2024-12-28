<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestComment extends Model
{
    use HasFactory;

    protected $fillable = ['message','request_id','user_id','is_seened'];

    public function request()
    {
        return $this->belongsTo('App\Models\Request', 'type_id', 'id');
    }
}
