<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->string('student_id', 26)->primary(); // ULID
            $table->string('name', 50);
            $table->string('email', 50)->unique();
            $table->char('nim', 50)->unique();
            $table->string('major');
            $table->date('enrollment_year');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};
