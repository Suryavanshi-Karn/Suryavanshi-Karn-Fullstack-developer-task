<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Student;


class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Create teachers
    Teacher::create(['teacher_name' => 'Mr. Smith']);
    Teacher::create(['teacher_name' => 'Ms. Johnson']);
    Teacher::create(['teacher_name' => 'Dr. Brown']);

    // Create students
    Student::create([
        'student_name' => 'John Doe',
        'class_teacher_id' => 1, // Teacher ID
        'class' => '10th Grade',
        'admission_date' => '2024-01-01',
        'yearly_fees' => 5000.00
    ]);
    }
}
