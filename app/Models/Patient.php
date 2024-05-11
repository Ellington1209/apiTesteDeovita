<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';


    public function getCpfAttribute($value)
    {
        return substr($value, 0, 3) . '.' . substr($value, 3, 3) . '.' . substr($value, 6, 3) . '-' . substr($value, 9, 2);
    }

    public function getPhoneAttribute($value)
    {
        return '(' . substr($value, 0, 2) . ') ' . substr($value, 2, 5) . '-' . substr($value, 7, 4);
    }

    public static function withUserDetails($groupId = 3)
    {
        return self::join('users', 'patients.user_id', '=', 'users.id')
            ->where('users.group_id', $groupId)
            ->select('users.*', 'patients.date_birth', 'patients.cpf', 'patients.phone', 'patients.sex');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function consultationRecords()
    {
        return $this->hasMany(ConsultationRecord::class, 'patient_id');
    }
}
