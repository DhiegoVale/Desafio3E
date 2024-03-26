<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'persons';
    use HasFactory;
    public function naturalPerson()
    {
        return $this->hasOne(Natural_Person::class);
    }
    public function LegalPerson()
    {
        return $this->hasOne(Legal_Person::class);
    }

}
