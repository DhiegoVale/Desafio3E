<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Legal_Person extends Model
{
    protected $table = 'legal_persons';
    use HasFactory;
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
