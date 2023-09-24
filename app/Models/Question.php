<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'answers' => 'array',
        'correct' => 'array'
    ];

    public function subjectClass()
    {
        return $this->belongsTo(SubjectClass::class);
    }
}
