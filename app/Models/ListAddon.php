<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListAddon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_id','fee'
    ];

    public function name()
    {
        return $this->belongsTo('App\Models\ListName', 'name_id', 'id');
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
