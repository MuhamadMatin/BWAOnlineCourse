<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseAnswer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'answer',
        'is_correct',
        'course_question_id',
    ];

    protected $guarded = [
        'id'
    ];
}
