<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%")
                  ->orWhere('ci', 'like', "%{$request->search}%");
            });
        }
        $students = $query->latest()->paginate(15);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ci' => 'required|string|unique:students,ci',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'mother_last_name' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'registration_number' => 'nullable|string|max:50',
            'discount' => 'nullable|numeric|min:0|max:100',
        ]);

        Student::create($data);
        return redirect()->route('students.index')->with('success', 'Estudiante registrado exitosamente.');
    }

    public function show(Student $student)
    {
        $student->load('enrollments.course', 'enrollments.paymentPlan.payments', 'documents');
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'ci' => 'required|string|unique:students,ci,' . $student->id,
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'mother_last_name' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'registration_number' => 'nullable|string|max:50',
            'discount' => 'nullable|numeric|min:0|max:100',
        ]);

        $student->update($data);
        return redirect()->route('students.index')->with('success', 'Estudiante actualizado.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Estudiante eliminado.');
    }
}
