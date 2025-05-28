<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lecturer extends Model
{
    use HasFactory;

    protected $primaryKey = 'lecturer_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'nip',
        'department',
        'email'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->lecturer_id)) {
                $model->lecturer_id = (string) Str::ulid();
            }
        });
    }

    // Relationships
    public function courseLecturers()
    {
        return $this->hasMany(CourseLecturer::class, 'lecturer_id', 'lecturer_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_lecturers', 'lecturer_id', 'course_id')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}