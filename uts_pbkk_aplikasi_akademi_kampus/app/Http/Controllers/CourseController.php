<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    public function index(): JsonResponse
    {
        $courses = Course::with(['enrollments', 'students', 'lecturers'])->paginate(10);
        return response()->json($courses);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:courses',
            'credits' => 'required|string',
            'semester' => 'required|string'
        ]);

        $course = Course::create($request->all());
        return response()->json($course, 201);
    }

    public function show(string $id): JsonResponse
    {
        $course = Course::with(['enrollments', 'students', 'lecturers'])->find($id);
        
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        return response()->json($course);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $course = Course::find($id);
        
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string',
            'code' => 'sometimes|string|unique:courses,code,' . $id . ',course_id',
            'credits' => 'sometimes|string',
            'semester' => 'sometimes|string'
        ]);

        $course->update($request->all());
        return response()->json($course);
    }

    public function destroy(string $id): JsonResponse
    {
        $course = Course::find($id);
        
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $course->delete();
        return response()->json(['message' => 'Course deleted successfully']);
    }
}