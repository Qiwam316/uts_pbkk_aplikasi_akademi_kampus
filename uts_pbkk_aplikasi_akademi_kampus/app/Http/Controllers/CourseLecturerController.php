<?php

namespace App\Http\Controllers;

use App\Models\CourseLecturer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CourseLecturerController extends Controller
{
    public function index(): JsonResponse
    {
        $courseLecturers = CourseLecturer::with(['course', 'lecturer'])->paginate(10);
        return response()->json($courseLecturers);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'course_id' => 'required|exists:courses,course_id',
            'lecturer_id' => 'required|exists:lecturers,lecturer_id',
            'role' => 'required|string'
        ]);

        $courseLecturer = CourseLecturer::create($request->all());
        return response()->json($courseLecturer->load(['course', 'lecturer']), 201);
    }

    public function show(string $id): JsonResponse
    {
        $courseLecturer = CourseLecturer::with(['course', 'lecturer'])->find($id);
        
        if (!$courseLecturer) {
            return response()->json(['message' => 'Course Lecturer not found'], 404);
        }

        return response()->json($courseLecturer);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $courseLecturer = CourseLecturer::find($id);
        
        if (!$courseLecturer) {
            return response()->json(['message' => 'Course Lecturer not found'], 404);
        }

        $request->validate([
            'course_id' => 'sometimes|exists:courses,course_id',
            'lecturer_id' => 'sometimes|exists:lecturers,lecturer_id',
            'role' => 'sometimes|string'
        ]);

        $courseLecturer->update($request->all());
        return response()->json($courseLecturer->load(['course', 'lecturer']));
    }

    public function destroy(string $id): JsonResponse
    {
        $courseLecturer = CourseLecturer::find($id);
        
        if (!$courseLecturer) {
            return response()->json(['message' => 'Course Lecturer not found'], 404);
        }

        $courseLecturer->delete();
        return response()->json(['message' => 'Course Lecturer deleted successfully']);
    }
}