<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\PaymentPlan;
use App\Models\Student;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with('student', 'course')->latest()->paginate(15);
        return view('enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $students = Student::orderBy('first_name')->get();
        $courses = Course::where('active', true)->get();
        return view('enrollments.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'enrollment_date' => 'required|date',
            'installments' => 'required|integer|min:1|max:12',
        ]);

        $course = Course::findOrFail($data['course_id']);

        if ($course->availableSlots() <= 0) {
            return back()->with('error', 'El curso no tiene cupos disponibles.');
        }

        $exists = Enrollment::where('student_id', $data['student_id'])
            ->where('course_id', $data['course_id'])->exists();
        if ($exists) {
            return back()->with('error', 'El estudiante ya está inscrito en este curso.');
        }

        $enrollment = Enrollment::create([
            'student_id' => $data['student_id'],
            'course_id' => $data['course_id'],
            'enrollment_date' => $data['enrollment_date'],
            'status' => 'active',
        ]);

        $plan = PaymentPlan::create([
            'enrollment_id' => $enrollment->id,
            'total_amount' => $course->cost,
            'total_installments' => $data['installments'],
        ]);

        $amountPerInstallment = $course->cost / $data['installments'];
        for ($i = 1; $i <= $data['installments']; $i++) {
            $plan->payments()->create([
                'installment_number' => $i,
                'amount' => $amountPerInstallment,
                'type' => $data['installments'] === 1 ? 'total' : 'partial',
                'status' => 'pending',
            ]);
        }

        return redirect()->route('enrollments.show', $enrollment)->with('success', 'Inscripción registrada.');
    }

    public function show(Enrollment $enrollment)
    {
        $enrollment->load('student', 'course', 'paymentPlan.payments');
        return view('enrollments.show', compact('enrollment'));
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->update(['status' => 'cancelled']);
        return redirect()->route('enrollments.index')->with('success', 'Inscripción cancelada.');
    }
}
