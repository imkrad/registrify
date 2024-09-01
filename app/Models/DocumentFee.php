<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id','document_id','fee'
    ];

    public function document()
    {
        return $this->belongsTo('App\Models\Document', 'document_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'type_id', 'id');
    }
    
    public function addons()
    {
        return $this->morphMany('App\Models\Addon', 'itemable');
    }

    public function setFeeAttribute($value)
    {
        $this->attributes['fee'] = trim(str_replace(',','',$value),'₱');
    }

    public function getFeeAttribute($value)
    {
        return '₱'.number_format($value,2,'.',',');
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
