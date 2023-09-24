<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function classes()
    {
        return $this->hasMany(SubjectClass::class);
    }

    public function kelas() : Attribute
    {
        return Attribute::get(fn() => $this->classes()->orderBy('id')->pluck('class'));
    }
}
