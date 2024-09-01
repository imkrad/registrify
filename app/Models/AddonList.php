<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddonList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_id','addon_id'
    ];

    public function name()
    {
        return $this->belongsTo('App\Models\ListName', 'name_id', 'id');
    }

    public function addon()
    {
        return $this->belongsTo('App\Models\Addon', 'addon_id', 'id');
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }
}
