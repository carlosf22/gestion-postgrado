<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentsController extends Controller
{
    public function store(Request $request, Student $student)
    {
        $data = $request->validate([
            'type' => 'required|string|max:50',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $file = $request->file('file');
        $path = $file->store("documents/{$student->id}", 'public');

        Documents::create([
            'student_id' => $student->id,
            'type' => $data['type'],
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
        ]);

        return back()->with('success', 'Documento subido.');
    }

    public function destroy(Documents $documents)
    {
        Storage::disk('public')->delete($documents->file_path);
        $documents->delete();
        return back()->with('success', 'Documento eliminado.');
    }
}
