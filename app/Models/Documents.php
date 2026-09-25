<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    //
    protected $fillable = ['student_id', 'type', 'file_path', 'original_name'];
    public function student() { return $this->belongsTo(Student::class); }
}
