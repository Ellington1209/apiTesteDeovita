<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\ConsultationRecord;
use App\Models\Doctor;
use App\Models\ExamsConsultation;
use App\Models\Patient;
use App\Models\PrescriptionRevenue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        // Obter o ID do médico logado
        $doctorId = Doctor::where('user_id', Auth::id())->firstOrFail()->id;

        // Buscar registros de consulta para esse médico
        $consultations = ConsultationRecord::with(['patient.user', 'examsConsultations.exam'])
            ->where('doctor_id', $doctorId)
            ->get()
            ->map(function ($consultation) {
                return [
                    'name' => $consultation->patient->user->name,
                    'email' => $consultation->patient->user->email,
                    'date' => $consultation->date,
                    'phone' => $consultation->patient->phone,
                    'sex' => $consultation->patient->sex,
                    'exams' => $consultation->examsConsultations->map(function ($ec) {
                        return $ec->exam->type_of_exam;
                    })->toArray()
                ];
            });

        return response()->json($consultations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'patientId' => 'required|integer',
        ]);


        DB::beginTransaction();

        try {
            $doctor = Doctor::where('user_id', auth()->id())->first();
            if (!$doctor) {
                return response()->json(['error' => 'Apenas médicos podem salvar consultas'], 404);
            }

            $patient = Patient::where('user_id', $request->patientId)->first();
            if (!$patient) {
                return response()->json(['error' => 'Paciente não encontrado'], 404);
            }

            $consultationRecord = new ConsultationRecord([
                'doctor_id' => $doctor->id,
                'patient_id' => $patient->id,
                'date' => Carbon::today()->toDateString(),
                'hours' => Carbon::now()->toTimeString(),
            ]);
            $consultationRecord->save();

            // Processa cada prescrição individualmente
            foreach ($request->prescription as $prescriptionText) {
                $prescriptionRevenue = new PrescriptionRevenue([
                    'consultation_record_id' => $consultationRecord->id,
                    'prescription' => $prescriptionText,
                ]);
                $prescriptionRevenue->save();
            }

            // Processa cada exame individualmente
            foreach ($request->selectedExams as $exam) {
                $examConsultation = new ExamsConsultation([
                    'consultation_record_id' => $consultationRecord->id,
                    'exam_id' => $exam['id'],
                ]);
                $examConsultation->save();
            }

            DB::commit();
            return response()->json(['message' => 'Consulta finalizada com sucesso!'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar consulta medic.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
