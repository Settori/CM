<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duty extends Model
{
    use HasFactory;

    public function points()
    {
        return $this->hasMany(Point::class);
    }

    protected $fillable = ['name', 'value'];

}
