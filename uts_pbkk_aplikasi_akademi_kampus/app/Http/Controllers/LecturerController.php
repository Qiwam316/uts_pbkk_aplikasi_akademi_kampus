<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LecturerController extends Controller
{
    public function index(): JsonResponse
    {
        $lecturers = Lecturer::with(['courses'])->paginate(10);
        return response()->json($lecturers);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'nip' => 'required|string|unique:lecturers',
            'department' => 'required|string',
            'email' => 'required|email|unique:lecturers'
        ]);

        $lecturer = Lecturer::create($request->all());
        return response()->json($lecturer, 201);
    }

    public function show(string $id): JsonResponse
    {
        $lecturer = Lecturer::with(['courses'])->find($id);
        
        if (!$lecturer) {
            return response()->json(['message' => 'Lecturer not found'], 404);
        }

        return response()->json($lecturer);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $lecturer = Lecturer::find($id);
        
        if (!$lecturer) {
            return response()->json(['message' => 'Lecturer not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string',
            'nip' => 'sometimes|string|unique:lecturers,nip,' . $id . ',lecturer_id',
            'department' => 'sometimes|string',
            'email' => 'sometimes|email|unique:lecturers,email,' . $id . ',lecturer_id'
        ]);

        $lecturer->update($request->all());
        return response()->json($lecturer);
    }

    public function destroy(string $id): JsonResponse
    {
        $lecturer = Lecturer::find($id);
        
        if (!$lecturer) {
            return response()->json(['message' => 'Lecturer not found'], 404);
        }

        $lecturer->delete();
        return response()->json(['message' => 'Lecturer deleted successfully']);
    }
}