<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname','middlename','lastname','suffix','email','contact_no','sex','id_number','status_id'
    ];

    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id');
    }

    public function setFirstnameAttribute($value)
    {
        $this->attributes['firstname'] = ucwords(strtolower($value));
    }

    public function setLastnameAttribute($value)
    {
        $this->attributes['lastname'] = ucwords(strtolower($value));
    }

    public function setMiddlenameAttribute($value)
    {
        $this->attributes['middlename'] = ucwords(strtolower($value));
    }

    public function setSuffixAttribute($value)
    {
        $this->attributes['suffix'] = ucwords(strtolower($value));
    }
  
}
