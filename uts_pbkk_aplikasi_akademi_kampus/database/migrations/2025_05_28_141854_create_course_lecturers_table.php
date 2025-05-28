<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('course_lecturers', function (Blueprint $table) {
            $table->string('id', 26)->primary(); // ULID
            $table->string('course_id', 26);
            $table->string('lecturer_id', 26);
            $table->string('role');
            $table->timestamps();

            $table->foreign('course_id')->references('course_id')->on('courses');
            $table->foreign('lecturer_id')->references('lecturer_id')->on('lecturers');
            $table->unique(['course_id', 'lecturer_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_lecturers');
    }
};