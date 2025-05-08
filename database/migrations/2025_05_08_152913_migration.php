<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Users Table (for all user types)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['student', 'company', 'admin'])->default('student');
            $table->string('profile_picture')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // Students Table (additional info for student users)
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nim')->unique();
            $table->string('university');
            $table->string('faculty');
            $table->string('study_program');
            $table->integer('semester');
            $table->text('skills')->nullable();
            $table->text('portfolio_url')->nullable();
            $table->text('cv_url')->nullable();
            $table->timestamps();
        });

        // Companies Table (additional info for company users)
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('industry');
            $table->text('description');
            $table->string('website_url')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('address');
            $table->string('phone');
            $table->timestamps();
        });

        // Internship Listings Table
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('requirements');
            $table->text('benefits')->nullable();
            $table->string('location');
            $table->enum('type', ['onsite', 'remote', 'hybrid']);
            $table->enum('duration_unit', ['week', 'month'])->default('month');
            $table->integer('duration_value');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('application_deadline');
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->integer('slot')->default(1);
            $table->timestamps();
        });

        // Skills Table (for tagging system)
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Applications Table
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('internship_id')->constrained('internships')->onDelete('cascade');
            $table->text('cover_letter')->nullable();
            $table->enum('status', ['submitted', 'reviewed', 'interview', 'accepted', 'rejected'])->default('submitted');
            $table->text('feedback')->nullable();
            $table->timestamps();
            $table->unique(['student_id', 'internship_id']);
        });

        // Saved Internships Table (bookmarks)
        Schema::create('saved_internships', function (Blueprint $table) {
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('internship_id')->constrained('internships')->onDelete('cascade');
            $table->primary(['student_id', 'internship_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('saved_internships');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('internships');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('students');
        Schema::dropIfExists('users');
    }
};