<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->string('enrollment_id', 26)->primary(); // ULID
            $table->string('student_id', 26);
            $table->string('course_id', 26);
            $table->string('grade')->nullable();
            $table->string('attendance')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students');
            $table->foreign('course_id')->references('course_id')->on('courses');
            $table->unique(['student_id', 'course_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
};