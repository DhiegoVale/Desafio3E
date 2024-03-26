<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
    public function localization()
    {
        return $this->belongsTo(Localization::class);
    }
}
