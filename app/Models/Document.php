<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
      'name_id','is_perpage','type_id','is_primary'
    ];

    public function type()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'type_id', 'id');
    }

    public function name()
    {
        return $this->belongsTo('App\Models\ListName', 'name_id', 'id');
    }

    public function fees()
    {
        return $this->hasMany('App\Models\DocumentFee', 'document_id');
    }

    public function addons()
    {
        return $this->morphMany('App\Models\Addon', 'itemable');
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
