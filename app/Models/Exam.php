<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    public function examsConsultations()
    {
        return $this->hasMany(ExamsConsultation::class, 'exam_id');
    }
}
