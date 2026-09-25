<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->paginate(15);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'edition' => 'required|integer|min:1',
            'version' => 'required|integer|min:1',
            'type' => 'required|string|max:50',
            'cost' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
        ]);
        Course::create($data);
        return redirect()->route('courses.index')->with('success', 'Curso creado.');
    }

    public function show(Course $course)
    {
        $course->load('enrollments.student');
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'edition' => 'required|integer|min:1',
            'version' => 'required|integer|min:1',
            'type' => 'required|string|max:50',
            'cost' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'active' => 'boolean',
        ]);
        $course->update($data);
        return redirect()->route('courses.index')->with('success', 'Curso actualizado.');
    }

    public function destroy(Course $course)
    {
        $course->update(['active' => false]);
        return redirect()->route('courses.index')->with('success', 'Curso desactivado.');
    }
}
