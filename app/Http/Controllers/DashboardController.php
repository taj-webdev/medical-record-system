<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function admin()
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        // ===== TOTAL DATA =====
        $totalPatients = DB::table('patients')->count();

        $registrationsToday = DB::table('registrations')
            ->whereDate('registration_date', $today)->count();

        $registrationsYesterday = DB::table('registrations')
            ->whereDate('registration_date', $yesterday)->count();

        $waitingQueue = DB::table('registrations')
            ->whereDate('registration_date', $today)
            ->where('status', 'waiting')->count();

        $medicalRecordsToday = DB::table('medical_records')
            ->whereDate('created_at', $today)->count();

        $medicalRecordsYesterday = DB::table('medical_records')
            ->whereDate('created_at', $yesterday)->count();

        $invoicesToday = DB::table('invoices')
            ->whereDate('created_at', $today)->count();

        $invoicesYesterday = DB::table('invoices')
            ->whereDate('created_at', $yesterday)->count();

        $revenueToday = DB::table('payments')
            ->whereDate('paid_at', $today)
            ->sum('amount');

        $revenueYesterday = DB::table('payments')
            ->whereDate('paid_at', $yesterday)
            ->sum('amount');

        // ===== PERCENT CALCULATOR =====
        $percent = fn($today, $yesterday) =>
            $yesterday > 0 ? round((($today - $yesterday) / $yesterday) * 100, 1) : 100;

        // ===== GRAPH DATA (7 DAYS) =====
        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $days[] = date('Y-m-d', strtotime("-$i days"));
        }

        $registrationChart = [];
        $revenueChart = [];

        foreach ($days as $day) {
            $registrationChart[] = DB::table('registrations')
                ->whereDate('registration_date', $day)->count();

            $revenueChart[] = DB::table('payments')
                ->whereDate('paid_at', $day)->sum('amount');
        }

        return view('dashboard.admin', compact(
            'totalPatients',
            'registrationsToday',
            'waitingQueue',
            'medicalRecordsToday',
            'invoicesToday',
            'revenueToday',
            'registrationChart',
            'revenueChart',
            'days'
        ))->with([
            'percentRegistrations' => $percent($registrationsToday, $registrationsYesterday),
            'percentMedical'       => $percent($medicalRecordsToday, $medicalRecordsYesterday),
            'percentInvoices'      => $percent($invoicesToday, $invoicesYesterday),
            'percentRevenue'       => $percent($revenueToday, $revenueYesterday),
        ]);
    }

    public function doctor()
    {
        $doctorId = session('user.doctor_id');

        if (!$doctorId) {
            abort(403, 'Doctor belum terhubung dengan data dokter.');
        }

        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        // ================= CARD DATA =================

        $patientsToday = DB::table('registrations')
            ->where('doctor_id', $doctorId)
            ->whereDate('registration_date', $today)
            ->count();

        $patientsYesterday = DB::table('registrations')
            ->where('doctor_id', $doctorId)
            ->whereDate('registration_date', $yesterday)
            ->count();

        $waitingToday = DB::table('registrations')
            ->where('doctor_id', $doctorId)
            ->where('status', 'waiting')
            ->whereDate('registration_date', $today)
            ->count();

        $waitingYesterday = DB::table('registrations')
            ->where('doctor_id', $doctorId)
            ->where('status', 'waiting')
            ->whereDate('registration_date', $yesterday)
            ->count();

        $medicalToday = DB::table('medical_records')
            ->join('registrations', 'registrations.id', '=', 'medical_records.registration_id')
            ->where('registrations.doctor_id', $doctorId)
            ->whereDate('medical_records.created_at', $today)
            ->count();

        $medicalYesterday = DB::table('medical_records')
            ->join('registrations', 'registrations.id', '=', 'medical_records.registration_id')
            ->where('registrations.doctor_id', $doctorId)
            ->whereDate('medical_records.created_at', $yesterday)
            ->count();

        $prescriptionToday = DB::table('prescriptions')
            ->join('medical_records', 'medical_records.id', '=', 'prescriptions.medical_record_id')
            ->join('registrations', 'registrations.id', '=', 'medical_records.registration_id')
            ->where('registrations.doctor_id', $doctorId)
            ->whereDate('prescriptions.created_at', $today)
            ->count();

        $prescriptionYesterday = DB::table('prescriptions')
            ->join('medical_records', 'medical_records.id', '=', 'prescriptions.medical_record_id')
            ->join('registrations', 'registrations.id', '=', 'medical_records.registration_id')
            ->where('registrations.doctor_id', $doctorId)
            ->whereDate('prescriptions.created_at', $yesterday)
            ->count();

        $vitalToday = DB::table('vital_signs')
            ->join('registrations', 'registrations.id', '=', 'vital_signs.registration_id')
            ->where('registrations.doctor_id', $doctorId)
            ->whereDate('vital_signs.created_at', $today)
            ->count();

        $vitalYesterday = DB::table('vital_signs')
            ->join('registrations', 'registrations.id', '=', 'vital_signs.registration_id')
            ->where('registrations.doctor_id', $doctorId)
            ->whereDate('vital_signs.created_at', $yesterday)
            ->count();

        // ================= PERCENT CALCULATOR =================

        $percent = fn ($today, $yesterday) =>
            $yesterday > 0
                ? round((($today - $yesterday) / $yesterday) * 100, 1)
                : 0;

        // ================= CHART (7 DAYS) =================

        $days = [];
        $patientChart = [];
        $medicalChart = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $days[] = $date;

            $patientChart[] = DB::table('registrations')
                ->where('doctor_id', $doctorId)
                ->whereDate('registration_date', $date)
                ->count();

            $medicalChart[] = DB::table('medical_records')
                ->join('registrations', 'registrations.id', '=', 'medical_records.registration_id')
                ->where('registrations.doctor_id', $doctorId)
                ->whereDate('medical_records.created_at', $date)
                ->count();
        }

        return view('dashboard.doctor', compact(
            'patientsToday','waitingToday','medicalToday',
            'prescriptionToday','vitalToday',
            'days','patientChart','medicalChart'
        ))->with([
            'percentPatients'     => $percent($patientsToday, $patientsYesterday),
            'percentWaiting'      => $percent($waitingToday, $waitingYesterday),
            'percentMedical'      => $percent($medicalToday, $medicalYesterday),
            'percentPrescription' => $percent($prescriptionToday, $prescriptionYesterday),
            'percentVital'        => $percent($vitalToday, $vitalYesterday),
        ]);
    }

    public function nurse()
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        // ================= CARD DATA =================

        // 1. Registrasi Hari Ini
        $registrationsToday = DB::table('registrations')
            ->whereDate('registration_date', $today)
            ->count();

        $registrationsYesterday = DB::table('registrations')
            ->whereDate('registration_date', $yesterday)
            ->count();

        // 2. Antrian Menunggu
        $waitingToday = DB::table('registrations')
            ->whereDate('registration_date', $today)
            ->where('status', 'waiting')
            ->count();

        $waitingYesterday = DB::table('registrations')
            ->whereDate('registration_date', $yesterday)
            ->where('status', 'waiting')
            ->count();

        // 3. Vital Sign Belum Diinput
        $vitalPendingToday = DB::table('registrations')
            ->leftJoin('vital_signs', 'vital_signs.registration_id', '=', 'registrations.id')
            ->whereDate('registrations.registration_date', $today)
            ->whereNull('vital_signs.id')
            ->count();

        $vitalPendingYesterday = DB::table('registrations')
            ->leftJoin('vital_signs', 'vital_signs.registration_id', '=', 'registrations.id')
            ->whereDate('registrations.registration_date', $yesterday)
            ->whereNull('vital_signs.id')
            ->count();

        // 4. Vital Sign Selesai Hari Ini
        $vitalDoneToday = DB::table('vital_signs')
            ->whereDate('created_at', $today)
            ->count();

        $vitalDoneYesterday = DB::table('vital_signs')
            ->whereDate('created_at', $yesterday)
            ->count();

        // 5. Pasien Siap Diperiksa Dokter
        $readyDoctorToday = DB::table('registrations')
            ->whereDate('registration_date', $today)
            ->where('status', 'examined')
            ->count();

        $readyDoctorYesterday = DB::table('registrations')
            ->whereDate('registration_date', $yesterday)
            ->where('status', 'examined')
            ->count();

        // ================= PERCENT CALCULATOR =================
        $percent = fn ($today, $yesterday) =>
            $yesterday > 0 ? round((($today - $yesterday) / $yesterday) * 100, 1) : 0;

        // ================= GRAPH (7 DAYS) =================
        $days = [];
        $registrationChart = [];
        $vitalChart = [];
        $waitingChart = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $days[] = $date;

            $registrationChart[] = DB::table('registrations')
                ->whereDate('registration_date', $date)
                ->count();

            $vitalChart[] = DB::table('vital_signs')
                ->whereDate('created_at', $date)
                ->count();

            $waitingChart[] = DB::table('registrations')
                ->whereDate('registration_date', $date)
                ->where('status', 'waiting')
                ->count();
        }

        return view('dashboard.nurse', compact(
            'registrationsToday',
            'waitingToday',
            'vitalPendingToday',
            'vitalDoneToday',
            'readyDoctorToday',
            'days',
            'registrationChart',
            'vitalChart',
            'waitingChart'
        ))->with([
            'percentRegistrations' => $percent($registrationsToday, $registrationsYesterday),
            'percentWaiting'       => $percent($waitingToday, $waitingYesterday),
            'percentVitalPending'  => $percent($vitalPendingToday, $vitalPendingYesterday),
            'percentVitalDone'     => $percent($vitalDoneToday, $vitalDoneYesterday),
            'percentReadyDoctor'   => $percent($readyDoctorToday, $readyDoctorYesterday),
        ]);
    }

    // ==============================
    // PASIEN - ADMIN (CRUD)
    // ==============================

    public function patients(Request $request)
    {
        $search = $request->search;

        $patients = DB::table('patients')
            ->when($search, function ($q) use ($search) {
                $q->where('medical_record_number', 'like', "%$search%")
                  ->orWhere('name', 'like', "%$search%")
                  ->orWhere('nik', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('patients.index', compact('patients', 'search'));
    }

    // ==============================
    // CREATE PAGE
    // ==============================
    public function patientsCreate()
    {
        return view('patients.create');
    }

    // ==============================
    // STORE DATA
    // ==============================
    public function patientsStore(Request $request)
    {
        $request->validate([
            'medical_record_number' => 'required|unique:patients,medical_record_number',
            'name'        => 'required|string|max:150',
            'gender'      => 'required|in:M,F',
            'nik'         => 'nullable|string|max:20',
            'birth_date'  => 'nullable|date',
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string',
        ]);

        DB::table('patients')->insert([
            'medical_record_number' => $request->medical_record_number,
            'name'        => $request->name,
            'nik'         => $request->nik,
            'gender'      => $request->gender,
            'birth_date'  => $request->birth_date,
            'phone'       => $request->phone,
            'address'     => $request->address,
            'created_at'  => now(),
        ]);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data Pasien Berhasil Ditambahkan');
    }

    // ==============================
    // EDIT PAGE
    // ==============================
    public function patientsEdit($id)
    {
        $patient = DB::table('patients')->where('id', $id)->first();

        if (!$patient) {
            abort(404);
        }

        return view('patients.edit', compact('patient'));
    }

    // ==============================
    // UPDATE DATA
    // ==============================
    public function patientsUpdate(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:150',
            'gender'      => 'required|in:M,F',
            'nik'         => 'nullable|string|max:20',
            'birth_date'  => 'nullable|date',
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string',
        ]);

        DB::table('patients')
            ->where('id', $id)
            ->update([
                'name'        => $request->name,
                'nik'         => $request->nik,
                'gender'      => $request->gender,
                'birth_date'  => $request->birth_date,
                'phone'       => $request->phone,
                'address'     => $request->address,
                'updated_at'  => now(),
            ]);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data Pasien Berhasil Diperbarui');
    }

    // ==============================
    // DELETE DATA
    // ==============================
    public function patientsDelete($id)
    {
        try {

            $deleted = DB::table('patients')
                ->where('id', $id)
                ->delete();

            if (!$deleted) {
                return redirect()
                    ->route('patients.index')
                    ->with('error', 'Data pasien tidak ditemukan');
            }

            return redirect()
                ->route('patients.index')
                ->with('success', 'Data Pasien Berhasil Dihapus');

        } catch (\Illuminate\Database\QueryException $e) {

            return redirect()
                ->route('registrations.index')
                ->with('error', 'Pasien tidak dapat dihapus karena memiliki riwayat registrasi');
        }
    }

    // ==============================
    // PASIEN - DOCTOR (READ ONLY)
    // ==============================
    public function patientsDoctor(Request $request)
    {
        $search = $request->search;

        $patients = DB::table('patients')
            ->when($search, function ($q) use ($search) {
                $q->where('medical_record_number', 'like', "%$search%")
                  ->orWhere('name', 'like', "%$search%")
                  ->orWhere('nik', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('patients.doctor', compact('patients', 'search'));
    }

    // ==============================
    // PASIEN - NURSE (READ ONLY)
    // ==============================
    public function patientsNurse(Request $request)
    {
        $search = $request->search;

        $patients = DB::table('patients')
            ->when($search, function ($q) use ($search) {
                $q->where('medical_record_number', 'like', "%$search%")
                  ->orWhere('name', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('patients.nurse', compact('patients', 'search'));
    }

    // ==============================
    // REGISTRASI - ADMIN (INDEX)
    // ==============================
    public function registrations(Request $request)
    {
        $search = $request->search;

        $registrations = DB::table('registrations')
            ->join('patients', 'patients.id', '=', 'registrations.patient_id')
            ->join('clinics', 'clinics.id', '=', 'registrations.clinic_id')
            ->leftJoin('doctors', 'doctors.id', '=', 'registrations.doctor_id')
            ->when($search, function ($q) use ($search) {
                $q->where('patients.name', 'like', "%$search%")
                  ->orWhere('patients.medical_record_number', 'like', "%$search%");
            })
            ->select(
                'registrations.*',
                'patients.name as patient_name',
                'patients.medical_record_number',
                'clinics.name as clinic_name',
                'doctors.name as doctor_name'
            )
            ->orderBy('registration_date', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('registrations.index', compact('registrations', 'search'));
    }

    // ==============================
    // REGISTRASI - CREATE PAGE
    // ==============================
    public function registrationsCreate()
    {
        $patients = DB::table('patients')->orderBy('name')->get();
        $clinics  = DB::table('clinics')->get();
        $doctors  = DB::table('doctors')->where('is_active', 1)->get();

        return view('registrations.create', compact('patients', 'clinics', 'doctors'));
    }

    // ==============================
    // REGISTRASI - STORE
    // ==============================
    public function registrationsStore(Request $request)
    {
        $request->validate([
            'patient_id'        => 'required|exists:patients,id',
            'clinic_id'         => 'required|exists:clinics,id',
            'doctor_id'         => 'nullable|exists:doctors,id',
            'registration_date' => 'required|date',
        ]);

        DB::table('registrations')->insert([
            'patient_id'        => $request->patient_id,
            'clinic_id'         => $request->clinic_id,
            'doctor_id'         => $request->doctor_id,
            'registration_date' => $request->registration_date,
            'status'            => 'waiting',
            'created_at'        => now(),
        ]);

        return redirect()
            ->route('registrations.index')
            ->with('success', 'Data Registrasi Berhasil Ditambahkan');
    }

    // ==============================
    // REGISTRASI - EDIT PAGE
    // ==============================
    public function registrationsEdit($id)
    {
        $registration = DB::table('registrations')->where('id', $id)->first();

        if (!$registration) {
            abort(404);
        }

        $patients = DB::table('patients')->orderBy('name')->get();
        $clinics  = DB::table('clinics')->get();
        $doctors  = DB::table('doctors')->where('is_active', 1)->get();

        return view('registrations.edit', compact(
            'registration',
            'patients',
            'clinics',
            'doctors'
        ));
    }

    // ==============================
    // REGISTRASI - UPDATE
    // ==============================
    public function registrationsUpdate(Request $request, $id)
    {
        $request->validate([
            'patient_id'        => 'required|exists:patients,id',
            'clinic_id'         => 'required|exists:clinics,id',
            'doctor_id'         => 'nullable|exists:doctors,id',
            'registration_date' => 'required|date',
            'status'            => 'required|in:waiting,examined,completed',
        ]);

        DB::table('registrations')
            ->where('id', $id)
            ->update([
                'patient_id'        => $request->patient_id,
                'clinic_id'         => $request->clinic_id,
                'doctor_id'         => $request->doctor_id,
                'registration_date' => $request->registration_date,
                'status'            => $request->status,
            ]);

        return redirect()
            ->route('registrations.index')
            ->with('success', 'Data Registrasi Berhasil Diperbarui');
    }
    
    // ==============================
    // DELETE
    // ==============================
    public function registrationsDelete($id)
    {
        DB::table('registrations')->where('id', $id)->delete();

        return redirect()
            ->route('registrations.index')
            ->with('success', 'Data Registrasi Berhasil Dihapus');
    }

    // ==============================
    // REGISTRASI - NURSE (INDEX)
    // ==============================
    public function registrationsNurse(Request $request)
    {
        $search = $request->search;

        $registrations = DB::table('registrations')
            ->join('patients', 'patients.id', '=', 'registrations.patient_id')
            ->join('clinics', 'clinics.id', '=', 'registrations.clinic_id')
            ->leftJoin('doctors', 'doctors.id', '=', 'registrations.doctor_id')
            ->leftJoin('vital_signs', 'vital_signs.registration_id', '=', 'registrations.id')
            ->when($search, function ($q) use ($search) {
                $q->where('patients.name', 'like', "%$search%")
                  ->orWhere('patients.medical_record_number', 'like', "%$search%");
            })
            ->select(
                'registrations.*',
                'patients.name as patient_name',
                'patients.medical_record_number',
                'clinics.name as clinic_name',
                'doctors.name as doctor_name',
                'vital_signs.id as vital_id'
            )
            ->orderBy('registration_date', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('registrations.nurse', compact('registrations', 'search'));
    }

    // ==============================
    // REGISTRASI - NURSE (SEND TO DOCTOR)
    // ==============================
    public function sendToDoctor($id)
    {
        $registration = DB::table('registrations')
            ->leftJoin('vital_signs', 'vital_signs.registration_id', '=', 'registrations.id')
            ->select('registrations.*', 'vital_signs.id as vital_id')
            ->where('registrations.id', $id)
            ->first();

        if (!$registration) {
            abort(404);
        }

        // ❌ Tidak boleh kalau belum ada vital sign
        if (!$registration->vital_id) {
            return back()->with('error', 'Vital Sign belum diinput');
        }

        // ❌ Tidak boleh kalau bukan waiting
        if ($registration->status !== 'waiting') {
            return back()->with('error', 'Status tidak valid');
        }

        // ✅ Update status
        DB::table('registrations')
            ->where('id', $id)
            ->update([
                'status' => 'examined'
            ]);

        return back()->with('success', 'Pasien berhasil dikirim ke Dokter');
    }

    // ==============================
    // VITAL SIGN - CREATE (NURSE)
    // ==============================
    public function vitalCreate($registrationId)
    {
        $registration = DB::table('registrations')
            ->join('patients', 'patients.id', '=', 'registrations.patient_id')
            ->leftJoin('vital_signs', 'vital_signs.registration_id', '=', 'registrations.id')
            ->select(
                'registrations.*',
                'patients.name as patient_name',
                'vital_signs.id as vital_id'
            )
            ->where('registrations.id', $registrationId)
            ->first();

        if (!$registration) {
            abort(404);
        }

        // ❌ Sudah ada vital sign → tidak boleh input ulang
        if ($registration->vital_id) {
            return redirect()->back()
                ->with('error', 'Vital Sign sudah diinput');
        }

        return view('vital.create', compact('registration'));
    }

    // ==============================
    // VITAL SIGN - STORE
    // ==============================
    public function vitalStore(Request $request, $registrationId)
    {
        $request->validate([
            'blood_pressure' => 'required',
            'heart_rate'     => 'required|numeric',
            'temperature'    => 'required|numeric',
            'weight'         => 'required|numeric',
            'height'         => 'required|numeric',
        ]);

        DB::table('vital_signs')->insert([
            'registration_id' => $registrationId,
            'blood_pressure'  => $request->blood_pressure,
            'heart_rate'      => $request->heart_rate,
            'temperature'     => $request->temperature,
            'weight'          => $request->weight,
            'height'          => $request->height,
            'created_at'      => now(),
        ]);

        return redirect()
            ->route('registrations.nurse')
            ->with('success', 'Vital Sign berhasil disimpan');
    }

    // ==============================
    // REKAM MEDIS - INDEX (DOCTOR)
    // ==============================
    public function medicalRecordsIndex(Request $request)
    {
        $roleId   = session('user.role_id');
        $doctorId = session('user.doctor_id');

        $search      = $request->search;
        $dateFrom    = $request->date_from;
        $dateTo      = $request->date_to;
        $doctorFilter = $request->doctor_id;

        $query = DB::table('registrations')
            ->join('patients', 'patients.id', '=', 'registrations.patient_id')
            ->leftJoin('medical_records', 'medical_records.registration_id', '=', 'registrations.id')
            ->leftJoin('doctors', 'doctors.id', '=', 'registrations.doctor_id')
            ->whereIn('registrations.status', ['examined','completed'])
            ->select(
                'registrations.*',
                'patients.name as patient_name',
                'patients.medical_record_number',
                'medical_records.id as medical_record_id',
                'doctors.name as doctor_name'
            );

        // 🔍 SEARCH
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('patients.name', 'like', "%$search%")
                  ->orWhere('patients.medical_record_number', 'like', "%$search%");
            });
        }

        // 📅 FILTER TANGGAL
        if ($dateFrom) {
            $query->whereDate('registrations.registration_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('registrations.registration_date', '<=', $dateTo);
        }

        // 👑 ADMIN FILTER DOCTOR
        if ($roleId == 1 && $doctorFilter) {
            $query->where('registrations.doctor_id', $doctorFilter);
        }

        // 🔒 DOCTOR hanya miliknya
        if ($roleId == 2) {
            $query->where('registrations.doctor_id', $doctorId);
        }

        // ================= EXPORT PDF =================
        if ($request->export == 'pdf') {

            $data = $query->orderBy('registration_date', 'desc')->get();

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
                'medical-records.export',
                compact('data')
            );

            return $pdf->download('daftar-rekam-medis.pdf');
        }

        $registrations = $query
            ->orderBy('registration_date', 'desc')
            ->paginate(10)
            ->withQueryString();

        $doctors = DB::table('doctors')->orderBy('name')->get();

        return view('medical-records.index', compact(
            'registrations',
            'search',
            'dateFrom',
            'dateTo',
            'doctorFilter',
            'doctors'
        ));
    }

    // ==============================
    // REKAM MEDIS - CREATE
    // ==============================
    public function medicalRecordsCreate($registrationId)
    {
        $doctorId = session('user.doctor_id');

        $registration = DB::table('registrations')
            ->join('patients', 'patients.id', '=', 'registrations.patient_id')
            ->where('registrations.id', $registrationId)
            ->where('registrations.doctor_id', $doctorId)
            ->select('registrations.*', 'patients.name as patient_name')
            ->first();

        if (!$registration) {
            abort(404);
        }

        $diagnoses = DB::table('diagnoses')->orderBy('name')->get();

        $vitalSign = DB::table('vital_signs')
            ->where('registration_id', $registrationId)
            ->first();

        return view('medical-records.create', compact(
            'registration',
            'diagnoses',
            'vitalSign'
        ));
    }

    // ==============================
    // REKAM MEDIS - STORE
    // ==============================
    public function medicalRecordsStore(Request $request, $registrationId)
    {
        $doctorId = session('user.doctor_id');

        $registration = DB::table('registrations')
            ->where('id', $registrationId)
            ->where('doctor_id', $doctorId)
            ->first();

        if (!$registration) {
            abort(403);
        }

        $request->validate([
            'complaint'    => 'required|string',
            'diagnosis_id' => 'required|exists:diagnoses,id',
            'notes'        => 'nullable|string',
        ]);

        DB::table('medical_records')->insert([
            'registration_id' => $registrationId,
            'complaint'       => $request->complaint,
            'diagnosis_id'    => $request->diagnosis_id,
            'notes'           => $request->notes,
            'created_at'      => now(),
        ]);

        DB::table('registrations')
            ->where('id', $registrationId)
            ->update([
                'status' => 'completed'
            ]);

        return redirect()
            ->route('medical-records.index')
            ->with('success', 'Rekam Medis Berhasil Disimpan');
    }

    // ==============================
    // TINDAKAN MEDIS - INDEX
    // ==============================
    public function medicalActions($medicalRecordId)
    {
        $roleId   = session('user.role_id');
        $doctorId = session('user.doctor_id');

        $medicalRecord = DB::table('medical_records')
            ->join('registrations', 'registrations.id', '=', 'medical_records.registration_id')
            ->join('patients', 'patients.id', '=', 'registrations.patient_id')
            ->select(
                'medical_records.*',
                'registrations.doctor_id',
                'patients.name as patient_name'
            )
            ->where('medical_records.id', $medicalRecordId)
            ->first();

        if (!$medicalRecord) {
            abort(404);
        }

        // 🔒 Doctor hanya boleh akses miliknya
        if ($roleId == 2 && $medicalRecord->doctor_id != $doctorId) {
            abort(403);
        }

        $actions = DB::table('medical_actions')->orderBy('name')->get();

        $selectedActions = DB::table('medical_record_actions')
            ->join('medical_actions', 'medical_actions.id', '=', 'medical_record_actions.medical_action_id')
            ->where('medical_record_id', $medicalRecordId)
            ->select(
                'medical_actions.name',
                'medical_record_actions.cost'
            )
            ->get();

        return view('medical-records.actions', compact(
            'medicalRecord',
            'actions',
            'selectedActions',
            'roleId'
        ));
    }

    // ==============================
    // TINDAKAN MEDIS - STORE
    // ==============================
    public function medicalActionsStore(Request $request, $medicalRecordId)
    {
        $roleId = session('user.role_id');

        // 👑 Admin tidak boleh store
        if ($roleId == 1) {
            abort(403);
        }

        $request->validate([
            'medical_action_id' => 'required|exists:medical_actions,id',
        ]);

        $action = DB::table('medical_actions')
            ->where('id', $request->medical_action_id)
            ->first();

        DB::table('medical_record_actions')->insert([
            'medical_record_id' => $medicalRecordId,
            'medical_action_id' => $action->id,
            'cost'              => $action->cost,
        ]);

        return back()->with('success', 'Tindakan Medis Ditambahkan');
    }

    // ==============================
    // RESEP - INDEX
    // ==============================
    public function prescriptions($medicalRecordId)
    {
        $roleId   = session('user.role_id');
        $doctorId = session('user.doctor_id');

        $medicalRecord = DB::table('medical_records')
            ->join('registrations', 'registrations.id', '=', 'medical_records.registration_id')
            ->join('patients', 'patients.id', '=', 'registrations.patient_id')
            ->select(
                'medical_records.id',
                'registrations.doctor_id',
                'patients.name as patient_name'
            )
            ->where('medical_records.id', $medicalRecordId)
            ->first();

        if (!$medicalRecord) {
            abort(404);
        }

        // 🔒 Doctor hanya akses miliknya
        if ($roleId == 2 && $medicalRecord->doctor_id != $doctorId) {
            abort(403);
        }

        $medicines = DB::table('medicines')->orderBy('name')->get();

        $prescription = DB::table('prescriptions')
            ->where('medical_record_id', $medicalRecordId)
            ->first();

        $items = [];

        if ($prescription) {
            $items = DB::table('prescription_items')
                ->join('medicines', 'medicines.id', '=', 'prescription_items.medicine_id')
                ->where('prescription_id', $prescription->id)
                ->select(
                    'medicines.name',
                    'prescription_items.quantity',
                    'prescription_items.price'
                )
                ->get();
        }

        return view('medical-records.prescriptions', compact(
            'medicalRecord',
            'medicines',
            'prescription',
            'items',
            'roleId'
        ));
    }

    // ==============================
    // RESEP - STORE
    // ==============================
    public function prescriptionsStore(Request $request, $medicalRecordId)
    {
        $roleId = session('user.role_id');

        // 👑 Admin tidak boleh tambah resep
        if ($roleId == 1) {
            abort(403);
        }

        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity'    => 'required|integer|min:1',
        ]);

        $medicine = DB::table('medicines')
            ->where('id', $request->medicine_id)
            ->first();

        $prescription = DB::table('prescriptions')
            ->where('medical_record_id', $medicalRecordId)
            ->first();

        if (!$prescription) {
            $prescriptionId = DB::table('prescriptions')->insertGetId([
                'medical_record_id' => $medicalRecordId,
                'created_at' => now(),
            ]);
        } else {
            $prescriptionId = $prescription->id;
        }

        DB::table('prescription_items')->insert([
            'prescription_id' => $prescriptionId,
            'medicine_id'     => $medicine->id,
            'quantity'        => $request->quantity,
            'price'           => $medicine->price,
        ]);

        return back()->with('success', 'Obat Berhasil Ditambahkan');
    }
    
    public function billingGenerate($registrationId)
    {
        // Pastikan hanya Admin
        if (session('user.role_id') != 1) {
            abort(403);
        }

        $registration = DB::table('registrations')
            ->where('id', $registrationId)
            ->first();

        if (!$registration) abort(404);

        // 🚫 Cek jika invoice sudah ada
        $existingInvoice = DB::table('invoices')
            ->where('registration_id', $registrationId)
            ->first();

        if ($existingInvoice) {
            return redirect()
                ->route('billing.show', $existingInvoice->id)
                ->with('info', 'Invoice sudah pernah dibuat.');
        }

        $medicalRecord = DB::table('medical_records')
            ->where('registration_id', $registrationId)
            ->first();

        if (!$medicalRecord) {
            return back()->withErrors('Rekam medis belum tersedia');
        }

        // Hitung tindakan
        $actionsTotal = DB::table('medical_record_actions')
            ->where('medical_record_id', $medicalRecord->id)
            ->sum('cost');

        // Hitung obat
        $medicineTotal = DB::table('prescription_items')
            ->join('prescriptions', 'prescriptions.id', '=', 'prescription_items.prescription_id')
            ->where('prescriptions.medical_record_id', $medicalRecord->id)
            ->sum(DB::raw('quantity * price'));

        $total = $actionsTotal + $medicineTotal;

        // 🔥 Generate invoice number profesional
        $today = now()->format('Ymd');
        $lastInvoice = DB::table('invoices')
            ->whereDate('created_at', today())
            ->count();

        $runningNumber = str_pad($lastInvoice + 1, 4, '0', STR_PAD_LEFT);

        $invoiceNumber = "INV/{$today}/{$runningNumber}";

        $invoiceId = DB::table('invoices')->insertGetId([
            'registration_id' => $registrationId,
            'invoice_number'  => $invoiceNumber,
            'total_amount'    => $total,
            'status'          => 'unpaid',
            'created_at'      => now(),
        ]);

        return redirect()
            ->route('billing.show', $invoiceId)
            ->with('success', 'Invoice Berhasil Dibuat');
    }

    public function billingIndex(Request $request)
    {
        if (session('user.role_id') != 1) {
            abort(403);
        }

        $search = $request->search;
        $status = $request->status;

        $query = DB::table('invoices')
            ->join('registrations', 'registrations.id', '=', 'invoices.registration_id')
            ->join('patients', 'patients.id', '=', 'registrations.patient_id')
            ->select(
                'invoices.*',
                'patients.name as patient_name'
            );

        // 🔍 SEARCH FILTER
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('patients.name', 'like', "%{$search}%")
                  ->orWhere('invoices.invoice_number', 'like', "%{$search}%");
            });
        }

        // 🎯 STATUS FILTER
        if (!empty($status)) {
            $query->where('invoices.status', $status);
        }

        $invoices = $query
            ->orderBy('invoices.created_at', 'desc')
            ->paginate(10)
            ->withQueryString(); // penting biar search tidak hilang saat pagination

        return view('billing.index', compact('invoices', 'search', 'status'));
    }

    public function billingShow($invoiceId)
    {
        // 🔒 Hanya Admin
        if (session('user.role_id') != 1) {
            abort(403);
        }

        // =========================
        // INVOICE + REGISTRATION + PATIENT
        // =========================
        $invoice = DB::table('invoices')
            ->join('registrations', 'registrations.id', '=', 'invoices.registration_id')
            ->join('patients', 'patients.id', '=', 'registrations.patient_id')
            ->where('invoices.id', $invoiceId)
            ->select(
                'invoices.*',
                'registrations.id as registration_id',
                'patients.name as patient_name'
            )
            ->first();

        if (!$invoice) {
            abort(404);
        }

        // =========================
        // MEDICAL RECORD
        // =========================
        $medicalRecord = DB::table('medical_records')
            ->where('registration_id', $invoice->registration_id)
            ->first();

        $actions = collect();
        $medicines = collect();

        if ($medicalRecord) {

            // =========================
            // TINDAKAN MEDIS
            // =========================
            $actions = DB::table('medical_record_actions')
                ->join('medical_actions', 'medical_actions.id', '=', 'medical_record_actions.medical_action_id')
                ->where('medical_record_actions.medical_record_id', $medicalRecord->id)
                ->select(
                    'medical_actions.name',
                    'medical_record_actions.cost'
                )
                ->get();

            // =========================
            // OBAT
            // =========================
            $medicines = DB::table('prescription_items')
                ->join('medicines', 'medicines.id', '=', 'prescription_items.medicine_id')
                ->join('prescriptions', 'prescriptions.id', '=', 'prescription_items.prescription_id')
                ->where('prescriptions.medical_record_id', $medicalRecord->id)
                ->select(
                    'medicines.name',
                    'prescription_items.quantity',
                    'prescription_items.price'
                )
                ->get();
        }

        // =========================
        // PAYMENT INFO (IF EXISTS)
        // =========================
        $payment = DB::table('payments')
            ->where('invoice_id', $invoiceId)
            ->first();

        return view('billing.show', [
            'invoice'   => $invoice,
            'patient'   => (object)['name' => $invoice->patient_name],
            'actions'   => $actions,
            'medicines' => $medicines,
            'payment'   => $payment
        ]);
    }
    
    public function billingPay(Request $request, $invoiceId)
    {
        if (session('user.role_id') != 1) {
            abort(403);
        }

        $invoice = DB::table('invoices')->where('id', $invoiceId)->first();
        if (!$invoice) abort(404);

        if ($invoice->status == 'paid') {
            return back()->withErrors('Invoice sudah dibayar.');
        }

        $request->validate([
            'payment_method' => 'required|string|max:50'
        ]);

        DB::table('payments')->insert([
            'invoice_id'     => $invoiceId,
            'payment_method' => $request->payment_method,
            'amount'         => $invoice->total_amount,
            'paid_at'        => now(),
        ]);

        DB::table('invoices')
            ->where('id', $invoiceId)
            ->update([
                'status' => 'paid'
            ]);

        return back()->with('success', 'Pembayaran Berhasil');
    }

    public function billingPrint($invoiceId)
    {
        $invoice = DB::table('invoices')->where('id', $invoiceId)->first();
        if (!$invoice) abort(404);

        $registration = DB::table('registrations')->where('id', $invoice->registration_id)->first();
        $patient = DB::table('patients')->where('id', $registration->patient_id)->first();
        $clinic = DB::table('clinics')->where('id', $registration->clinic_id)->first();

        $medicalRecord = DB::table('medical_records')
            ->where('registration_id', $registration->id)
            ->first();

        $actions = DB::table('medical_record_actions')
            ->join('medical_actions', 'medical_actions.id', '=', 'medical_record_actions.medical_action_id')
            ->where('medical_record_actions.medical_record_id', $medicalRecord->id)
            ->select('medical_actions.name', 'medical_record_actions.cost')
            ->get();

        $medicines = DB::table('prescription_items')
            ->join('medicines', 'medicines.id', '=', 'prescription_items.medicine_id')
            ->join('prescriptions', 'prescriptions.id', '=', 'prescription_items.prescription_id')
            ->where('prescriptions.medical_record_id', $medicalRecord->id)
            ->select(
                'medicines.name',
                'prescription_items.quantity',
                'prescription_items.price'
            )
            ->get();

        $pdf = Pdf::loadView('billing.invoice-pdf', compact(
            'invoice',
            'patient',
            'clinic',
            'actions',
            'medicines'
        ))->setPaper('a4');

        // 🔥 SANITIZE FILE NAME (WAJIB)
        $cleanInvoiceNumber = str_replace(['/', '\\'], '-', $invoice->invoice_number);

        return $pdf->download('Invoice-' . $cleanInvoiceNumber . '.pdf');

    }

    // ==============================
    // MASTER KLINIK - INDEX
    // ==============================
    public function clinicsIndex(Request $request)
    {
        $search = $request->search;

        $clinics = DB::table('clinics')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('master.clinics.index', compact('clinics', 'search'));
    }

    // CREATE
    public function clinicsCreate()
    {
        return view('master.clinics.create');
    }

    // STORE
    public function clinicsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150',
            'description' => 'nullable|max:255'
        ]);

        DB::table('clinics')->insert([
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => now()
        ]);

        return redirect()
            ->route('master.clinics.index')
            ->with('success', 'Data Klinik Berhasil Ditambahkan');
    }

    // EDIT
    public function clinicsEdit($id)
    {
        $clinic = DB::table('clinics')->where('id', $id)->first();
        if (!$clinic) abort(404);

        return view('master.clinics.edit', compact('clinic'));
    }

    // UPDATE
    public function clinicsUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:150',
            'description' => 'nullable|max:255'
        ]);

        DB::table('clinics')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

        return redirect()
            ->route('master.clinics.index')
            ->with('success', 'Data Klinik Berhasil Diperbarui');
    }

    // DELETE
    public function clinicsDelete($id)
    {
        DB::table('clinics')->where('id', $id)->delete();

        return redirect()
            ->route('master.clinics.index')
            ->with('success', 'Data Klinik Berhasil Dihapus');
    }

    // ==============================
    // MASTER DOKTER - INDEX
    // ==============================
    public function masterDoctors(Request $request)
    {
        $search = $request->search;

        $doctors = DB::table('doctors')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('specialization', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('master.doctors.index', compact('doctors', 'search'));
    }

    // ==============================
    // CREATE
    // ==============================
    public function masterDoctorsCreate()
    {
        return view('master.doctors.create');
    }

    // ==============================
    // STORE
    // ==============================
    public function masterDoctorsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150',
            'specialization' => 'nullable|max:100',
            'phone' => 'nullable|max:30',
        ]);

        DB::table('doctors')->insert([
            'name' => $request->name,
            'specialization' => $request->specialization,
            'phone' => $request->phone,
            'is_active' => 1,
            'created_at' => now()
        ]);

        return redirect()
            ->route('master.doctors.index')
            ->with('success', 'Data Dokter Berhasil Ditambahkan');
    }

    // ==============================
    // EDIT
    // ==============================
    public function masterDoctorsEdit($id)
    {
        $doctor = DB::table('doctors')->where('id', $id)->first();
        abort_if(!$doctor, 404);

        return view('master.doctors.edit', compact('doctor'));
    }

    // ==============================
    // UPDATE
    // ==============================
    public function masterDoctorsUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:150',
            'specialization' => 'nullable|max:100',
            'phone' => 'nullable|max:30',
            'is_active' => 'required|boolean'
        ]);

        DB::table('doctors')->where('id', $id)->update([
            'name' => $request->name,
            'specialization' => $request->specialization,
            'phone' => $request->phone,
            'is_active' => $request->is_active,
        ]);

        return redirect()
            ->route('master.doctors.index')
            ->with('success', 'Data Dokter Berhasil Diperbarui');
    }

    // ==============================
    // DELETE
    // ==============================
    public function masterDoctorsDelete($id)
    {
        DB::table('doctors')->where('id', $id)->delete();

        return redirect()
            ->route('master.doctors.index')
            ->with('success', 'Data Dokter Berhasil Dihapus');
    }

    // ==============================
    // MASTER DIAGNOSIS - INDEX
    // ==============================
    public function diagnoses(Request $request)
    {
        $search = $request->search;

        $diagnoses = DB::table('diagnoses')
            ->when($search, function ($q) use ($search) {
                $q->where('code', 'like', "%$search%")
                  ->orWhere('name', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('master.diagnoses.index', compact('diagnoses', 'search'));
    }

    // CREATE
    public function diagnosesCreate()
    {
        return view('master.diagnoses.create');
    }

    // STORE
    public function diagnosesStore(Request $request)
    {
        $request->validate([
            'code' => 'nullable|string|max:20',
            'name' => 'required|string|max:255'
        ]);

        DB::table('diagnoses')->insert([
            'code' => $request->code,
            'name' => $request->name,
            'created_at' => now()
        ]);

        return redirect()
            ->route('master.diagnoses.index')
            ->with('success', 'Data Diagnosa Berhasil Ditambahkan');
    }

    // EDIT
    public function diagnosesEdit($id)
    {
        $diagnosis = DB::table('diagnoses')->where('id', $id)->first();

        if (!$diagnosis) abort(404);

        return view('master.diagnoses.edit', compact('diagnosis'));
    }

    // UPDATE
    public function diagnosesUpdate(Request $request, $id)
    {
        $request->validate([
            'code' => 'nullable|string|max:20',
            'name' => 'required|string|max:255'
        ]);

        DB::table('diagnoses')
            ->where('id', $id)
            ->update([
                'code' => $request->code,
                'name' => $request->name
            ]);

        return redirect()
            ->route('master.diagnoses.index')
            ->with('success', 'Data Diagnosa Berhasil Diperbarui');
    }

    // DELETE
    public function diagnosesDelete($id)
    {
        DB::table('diagnoses')->where('id', $id)->delete();

        return redirect()
            ->route('master.diagnoses.index')
            ->with('success', 'Data Diagnosa Berhasil Dihapus');
    }

    // ==============================
    // MASTER TINDAKAN MEDIS - INDEX
    // ==============================
    public function actions(Request $request)
    {
        $search = $request->search;

        $actions = DB::table('medical_actions')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('master.actions.index', compact('actions', 'search'));
    }

    // CREATE
    public function actionsCreate()
    {
        return view('master.actions.create');
    }

    // STORE
    public function actionsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'cost' => 'required|numeric|min:0'
        ]);

        DB::table('medical_actions')->insert([
            'name' => $request->name,
            'cost' => $request->cost,
            'created_at' => now()
        ]);

        return redirect()
            ->route('master.actions.index')
            ->with('success', 'Data Tindakan Medis Berhasil Ditambahkan');
    }

    // EDIT
    public function actionsEdit($id)
    {
        $action = DB::table('medical_actions')->where('id', $id)->first();
        if (!$action) abort(404);

        return view('master.actions.edit', compact('action'));
    }

    // UPDATE
    public function actionsUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'cost' => 'required|numeric|min:0'
        ]);

        DB::table('medical_actions')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'cost' => $request->cost
            ]);

        return redirect()
            ->route('master.actions.index')
            ->with('success', 'Data Tindakan Medis Berhasil Diperbarui');
    }

    // DELETE
    public function actionsDelete($id)
    {
        DB::table('medical_actions')->where('id', $id)->delete();

        return redirect()
            ->route('master.actions.index')
            ->with('success', 'Data Tindakan Medis Berhasil Dihapus');
    }

    // ==============================
    // MASTER OBAT - INDEX
    // ==============================
    public function medicines(Request $request)
    {
        $search = $request->search;

        $medicines = DB::table('medicines')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('master.medicines.index', compact('medicines', 'search'));
    }

    // CREATE
    public function medicinesCreate()
    {
        return view('master.medicines.create');
    }

    // STORE
    public function medicinesStore(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:150',
            'unit'  => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        DB::table('medicines')->insert([
            'name'       => $request->name,
            'unit'       => $request->unit,
            'price'      => $request->price,
            'stock'      => $request->stock,
            'created_at' => now()
        ]);

        return redirect()
            ->route('master.medicines.index')
            ->with('success', 'Data Obat Berhasil Ditambahkan');
    }

    // EDIT
    public function medicinesEdit($id)
    {
        $medicine = DB::table('medicines')->where('id', $id)->first();
        if (!$medicine) abort(404);

        return view('master.medicines.edit', compact('medicine'));
    }

    // UPDATE
    public function medicinesUpdate(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:150',
            'unit'  => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        DB::table('medicines')
            ->where('id', $id)
            ->update([
                'name'  => $request->name,
                'unit'  => $request->unit,
                'price' => $request->price,
                'stock' => $request->stock
            ]);

        return redirect()
            ->route('master.medicines.index')
            ->with('success', 'Data Obat Berhasil Diperbarui');
    }

    // DELETE
    public function medicinesDelete($id)
    {
        DB::table('medicines')->where('id', $id)->delete();

        return redirect()
            ->route('master.medicines.index')
            ->with('success', 'Data Obat Berhasil Dihapus');
    }

    // ==============================
    // ROLE INDEX
    // ==============================
    public function roles(Request $request)
    {
        $search = $request->search;

        $roles = DB::table('roles')
            ->when($search, fn($q) =>
                $q->where('name', 'like', "%$search%"))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('master.roles.index', compact('roles','search'));
    }

    // CREATE
    public function rolesCreate()
    {
        return view('master.roles.create');
    }

    // STORE
    public function rolesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'description' => 'nullable|string'
        ]);

        DB::table('roles')->insert([
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => now()
        ]);

        return redirect()->route('master.roles.index')
            ->with('success','Role Berhasil Ditambahkan');
    }

    // EDIT
    public function rolesEdit($id)
    {
        $role = DB::table('roles')->where('id',$id)->first();
        if(!$role) abort(404);

        return view('master.roles.edit',compact('role'));
    }

    // UPDATE
    public function rolesUpdate(Request $request,$id)
    {
        $request->validate([
            'name' => "required|unique:roles,name,$id",
            'description' => 'nullable|string'
        ]);

        DB::table('roles')->where('id',$id)->update([
            'name'=>$request->name,
            'description'=>$request->description
        ]);

        return redirect()->route('master.roles.index')
            ->with('success','Role Berhasil Diperbarui');
    }

    // DELETE
    public function rolesDelete($id)
    {
        DB::table('roles')->where('id',$id)->delete();

        return redirect()->route('master.roles.index')
            ->with('success','Role Berhasil Dihapus');
    }

    // ==============================
    // USER INDEX
    // ==============================
    public function users(Request $request)
    {
        $search = $request->search;

        $users = DB::table('users')
            ->join('roles','roles.id','=','users.role_id')
            ->select('users.*','roles.name as role_name')
            ->when($search,function($q) use($search){
                $q->where('users.name','like',"%$search%")
                  ->orWhere('users.username','like',"%$search%");
            })
            ->orderBy('users.created_at','desc')
            ->paginate(10)
            ->withQueryString();

        return view('master.users.index',compact('users','search'));
    }

    // CREATE
    public function usersCreate()
    {
        $roles = DB::table('roles')->get();
        return view('master.users.create',compact('roles'));
    }

    // STORE
    public function usersStore(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'username'=>'required|unique:users,username',
            'password'=>'required|min:6',
            'role_id'=>'required'
        ]);

        DB::table('users')->insert([
            'name'=>$request->name,
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'role_id'=>$request->role_id,
            'is_active'=>1,
            'created_at'=>now()
        ]);

        return redirect()->route('master.users.index')
            ->with('success','User Berhasil Ditambahkan');
    }

    // EDIT
    public function usersEdit($id)
    {
        $user = DB::table('users')->where('id',$id)->first();
        $roles = DB::table('roles')->get();

        return view('master.users.edit',compact('user','roles'));
    }

    // UPDATE
    public function usersUpdate(Request $request,$id)
    {
        $data = [
            'name'=>$request->name,
            'username'=>$request->username,
            'email'=>$request->email,
            'role_id'=>$request->role_id
        ];

        if($request->password){
            $data['password']=bcrypt($request->password);
        }

        DB::table('users')->where('id',$id)->update($data);

        return redirect()->route('master.users.index')
            ->with('success','User Berhasil Diperbarui');
    }

    // DELETE
    public function usersDelete($id)
    {
        DB::table('users')->where('id',$id)->delete();

        return redirect()->route('master.users.index')
            ->with('success','User Berhasil Dihapus');
    }
}
