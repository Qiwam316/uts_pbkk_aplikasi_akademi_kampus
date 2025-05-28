<?php


namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    public function index(): JsonResponse
    {
        $students = Student::with(['enrollments', 'courses'])->paginate(10);
        return response()->json($students);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:students',
            'nim' => 'required|string|max:50|unique:students',
            'major' => 'required|string',
            'enrollment_year' => 'required|date'
        ]);

        $student = Student::create($request->all());
        return response()->json($student, 201);
    }

    public function show(string $id): JsonResponse
    {
        $student = Student::with(['enrollments', 'courses'])->find($id);
        
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        return response()->json($student);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $student = Student::find($id);
        
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:50',
            'email' => 'sometimes|email|max:50|unique:students,email,' . $id . ',student_id',
            'nim' => 'sometimes|string|max:50|unique:students,nim,' . $id . ',student_id',
            'major' => 'sometimes|string',
            'enrollment_year' => 'sometimes|date'
        ]);

        $student->update($request->all());
        return response()->json($student);
    }

    public function destroy(string $id): JsonResponse
    {
        $student = Student::find($id);
        
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $student->delete();
        return response()->json(['message' => 'Student deleted successfully']);
    }
}