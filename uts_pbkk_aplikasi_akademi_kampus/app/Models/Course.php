<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $primaryKey = 'course_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'code',
        'credits',
        'semester'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->course_id)) {
                $model->course_id = (string) Str::ulid();
            }
        });
    }

    // Relationships
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id', 'course_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments', 'course_id', 'student_id')
                    ->withPivot('grade', 'attendance', 'status')
                    ->withTimestamps();
    }

    public function courseLecturers()
    {
        return $this->hasMany(CourseLecturer::class, 'course_id', 'course_id');
    }

    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class, 'course_lecturers', 'course_id', 'lecturer_id')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}