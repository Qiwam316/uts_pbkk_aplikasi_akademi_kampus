<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EnrollmentController extends Controller
{
    public function index(): JsonResponse
    {
        $enrollments = Enrollment::with(['student', 'course'])->paginate(10);
        return response()->json($enrollments);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'course_id' => 'required|exists:courses,course_id',
            'grade' => 'nullable|string',
            'attendance' => 'nullable|string',
            'status' => 'required|string'
        ]);

        $enrollment = Enrollment::create($request->all());
        return response()->json($enrollment->load(['student', 'course']), 201);
    }

    public function show(string $id): JsonResponse
    {
        $enrollment = Enrollment::with(['student', 'course'])->find($id);
        
        if (!$enrollment) {
            return response()->json(['message' => 'Enrollment not found'], 404);
        }

        return response()->json($enrollment);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $enrollment = Enrollment::find($id);
        
        if (!$enrollment) {
            return response()->json(['message' => 'Enrollment not found'], 404);
        }

        $request->validate([
            'student_id' => 'sometimes|exists:students,student_id',
            'course_id' => 'sometimes|exists:courses,course_id',
            'grade' => 'nullable|string',
            'attendance' => 'nullable|string',
            'status' => 'sometimes|string'
        ]);

        $enrollment->update($request->all());
        return response()->json($enrollment->load(['student', 'course']));
    }

    public function destroy(string $id): JsonResponse
    {
        $enrollment = Enrollment::find($id);
        
        if (!$enrollment) {
            return response()->json(['message' => 'Enrollment not found'], 404);
        }

        $enrollment->delete();
        return response()->json(['message' => 'Enrollment deleted successfully']);
    }
}