<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Natural_Person extends Model
{
    protected $table = 'natural_persons';
    use HasFactory;
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
