<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

// AUTH
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| PROTECTED (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware('auth.custom')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:Admin')->group(function () {

        // DASHBOARD
        Route::get('/dashboard', [DashboardController::class, 'admin'])
            ->name('dashboard.admin');

        /*
        |--------------------------------------------------------------------------
        | PASIEN (CRUD)
        |--------------------------------------------------------------------------
        */
        Route::get('/pasien', [DashboardController::class, 'patients'])
            ->name('patients.index');

        Route::get('/pasien/create', [DashboardController::class, 'patientsCreate'])
            ->name('patients.create');

        Route::post('/pasien', [DashboardController::class, 'patientsStore'])
            ->name('patients.store');

        Route::get('/pasien/{id}/edit', [DashboardController::class, 'patientsEdit'])
            ->name('patients.edit');

        Route::post('/pasien/{id}', [DashboardController::class, 'patientsUpdate'])
            ->name('patients.update');

        Route::delete('/pasien/{id}', [DashboardController::class, 'patientsDelete'])
            ->name('patients.delete');

        /*
        |--------------------------------------------------------------------------
        | REGISTRASI & ANTRIAN (ADMIN)
        |--------------------------------------------------------------------------
        */
        Route::get('/registrasi', [DashboardController::class, 'registrations'])
            ->name('registrations.index');

        Route::get('/registrasi/create', [DashboardController::class, 'registrationsCreate'])
            ->name('registrations.create');

        Route::post('/registrasi', [DashboardController::class, 'registrationsStore'])
            ->name('registrations.store');

        Route::get('/registrasi/{id}/edit', [DashboardController::class, 'registrationsEdit'])
            ->name('registrations.edit');

        Route::post('/registrasi/{id}', [DashboardController::class, 'registrationsUpdate'])
            ->name('registrations.update');

        Route::delete('/registrasi/{id}', [DashboardController::class, 'registrationsDelete'])
            ->name('registrations.delete');

        /*
        |--------------------------------------------------------------------------
        | BILLING & INVOICE (ADMIN)
        |--------------------------------------------------------------------------
        */
        Route::get('/billing', [DashboardController::class, 'billingIndex'])
            ->name('billing.index');

        Route::get('/billing/{invoiceId}', [DashboardController::class, 'billingShow'])
            ->name('billing.show');

        Route::post('/billing/{invoiceId}/pay', [DashboardController::class, 'billingPay'])
            ->name('billing.pay');

        Route::post('/billing/generate/{registrationId}', [DashboardController::class, 'billingGenerate'])
            ->name('billing.generate');

        Route::get('/billing/{invoiceId}/print', [DashboardController::class, 'billingPrint'])
            ->name('billing.print');

        // MASTER DATA
        Route::get('/master-data', function () {
            return view('master.index');
        })->name('master.index');

        /*
        |--------------------------------------------------------------------------
        | MASTER DATA - KLINIK
        |--------------------------------------------------------------------------
        */

        Route::get('/master/clinics', [DashboardController::class, 'clinicsIndex'])
            ->name('master.clinics.index');

        Route::get('/master/clinics/create', [DashboardController::class, 'clinicsCreate'])
            ->name('master.clinics.create');

        Route::post('/master/clinics', [DashboardController::class, 'clinicsStore'])
            ->name('master.clinics.store');

        Route::get('/master/clinics/{id}/edit', [DashboardController::class, 'clinicsEdit'])
            ->name('master.clinics.edit');

        Route::post('/master/clinics/{id}', [DashboardController::class, 'clinicsUpdate'])
            ->name('master.clinics.update');

        Route::delete('/master/clinics/{id}', [DashboardController::class, 'clinicsDelete'])
            ->name('master.clinics.delete');

        // ==============================
        // MASTER DOKTER
        // ==============================
        Route::get('/master/dokter', [DashboardController::class, 'masterDoctors'])
            ->name('master.doctors.index');

        Route::get('/master/dokter/create', [DashboardController::class, 'masterDoctorsCreate'])
            ->name('master.doctors.create');

        Route::post('/master/dokter', [DashboardController::class, 'masterDoctorsStore'])
            ->name('master.doctors.store');

        Route::get('/master/dokter/{id}/edit', [DashboardController::class, 'masterDoctorsEdit'])
            ->name('master.doctors.edit');

        Route::post('/master/dokter/{id}', [DashboardController::class, 'masterDoctorsUpdate'])
            ->name('master.doctors.update');

        Route::delete('/master/dokter/{id}', [DashboardController::class, 'masterDoctorsDelete'])
            ->name('master.doctors.delete');

        // ==============================
        // MASTER DIAGNOSIS
        // ==============================
        Route::get('/master/diagnosis', [DashboardController::class, 'diagnoses'])
            ->name('master.diagnoses.index');

        Route::get('/master/diagnosis/create', [DashboardController::class, 'diagnosesCreate'])
            ->name('master.diagnoses.create');

        Route::post('/master/diagnosis', [DashboardController::class, 'diagnosesStore'])
            ->name('master.diagnoses.store');

        Route::get('/master/diagnosis/{id}/edit', [DashboardController::class, 'diagnosesEdit'])
            ->name('master.diagnoses.edit');

        Route::post('/master/diagnosis/{id}', [DashboardController::class, 'diagnosesUpdate'])
            ->name('master.diagnoses.update');

        Route::delete('/master/diagnosis/{id}', [DashboardController::class, 'diagnosesDelete'])
            ->name('master.diagnoses.delete');

        // ==============================
        // MASTER TINDAKAN MEDIS
        // ==============================
        Route::get('/master/actions', [DashboardController::class, 'actions'])
            ->name('master.actions.index');

        Route::get('/master/actions/create', [DashboardController::class, 'actionsCreate'])
            ->name('master.actions.create');

        Route::post('/master/actions', [DashboardController::class, 'actionsStore'])
            ->name('master.actions.store');

        Route::get('/master/actions/{id}/edit', [DashboardController::class, 'actionsEdit'])
            ->name('master.actions.edit');

        Route::post('/master/actions/{id}', [DashboardController::class, 'actionsUpdate'])
            ->name('master.actions.update');

        Route::delete('/master/actions/{id}', [DashboardController::class, 'actionsDelete'])
            ->name('master.actions.delete');

        // ==============================
        // MASTER OBAT
        // ==============================
        Route::get('/master/medicines', [DashboardController::class, 'medicines'])
            ->name('master.medicines.index');

        Route::get('/master/medicines/create', [DashboardController::class, 'medicinesCreate'])
            ->name('master.medicines.create');

        Route::post('/master/medicines', [DashboardController::class, 'medicinesStore'])
            ->name('master.medicines.store');

        Route::get('/master/medicines/{id}/edit', [DashboardController::class, 'medicinesEdit'])
            ->name('master.medicines.edit');

        Route::post('/master/medicines/{id}', [DashboardController::class, 'medicinesUpdate'])
            ->name('master.medicines.update');

        Route::delete('/master/medicines/{id}', [DashboardController::class, 'medicinesDelete'])
            ->name('master.medicines.delete');

        // ==============================
        // MASTER ROLE
        // ==============================
        Route::get('/master/roles', [DashboardController::class, 'roles'])
            ->name('master.roles.index');

        Route::get('/master/roles/create', [DashboardController::class, 'rolesCreate'])
            ->name('master.roles.create');

        Route::post('/master/roles', [DashboardController::class, 'rolesStore'])
            ->name('master.roles.store');

        Route::get('/master/roles/{id}/edit', [DashboardController::class, 'rolesEdit'])
            ->name('master.roles.edit');

        Route::post('/master/roles/{id}', [DashboardController::class, 'rolesUpdate'])
            ->name('master.roles.update');

        Route::delete('/master/roles/{id}', [DashboardController::class, 'rolesDelete'])
            ->name('master.roles.delete');


        // ==============================
        // MASTER USER
        // ==============================
        Route::get('/master/users', [DashboardController::class, 'users'])
            ->name('master.users.index');

        Route::get('/master/users/create', [DashboardController::class, 'usersCreate'])
            ->name('master.users.create');

        Route::post('/master/users', [DashboardController::class, 'usersStore'])
            ->name('master.users.store');

        Route::get('/master/users/{id}/edit', [DashboardController::class, 'usersEdit'])
            ->name('master.users.edit');

        Route::post('/master/users/{id}', [DashboardController::class, 'usersUpdate'])
            ->name('master.users.update');

        Route::delete('/master/users/{id}', [DashboardController::class, 'usersDelete'])
            ->name('master.users.delete');
    });

    /*
    |--------------------------------------------------------------------------
    | DOCTOR
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:Doctor')->group(function () {

        // DASHBOARD
        Route::get('/dashboard-doctor', [DashboardController::class, 'doctor'])
            ->name('dashboard.doctor');

        // PASIEN (READ)
        Route::get('/pasien/doctor', [DashboardController::class, 'patientsDoctor'])
            ->name('patients.doctor');

        /*
        |--------------------------------------------------------------------------
        | REKAM MEDIS - DOCTOR (FULL)
        |--------------------------------------------------------------------------
        */
        Route::get('/rekam-medis/{registrationId}/create',
            [DashboardController::class, 'medicalRecordsCreate'])
            ->name('medical-records.create');

        Route::post('/rekam-medis/{registrationId}',
            [DashboardController::class, 'medicalRecordsStore'])
            ->name('medical-records.store');

        // TINDAKAN MEDIS
        Route::get('/rekam-medis/{medicalRecordId}/tindakan',
            [DashboardController::class, 'medicalActions'])
            ->name('medical-actions.index');

        Route::post('/rekam-medis/{medicalRecordId}/tindakan',
            [DashboardController::class, 'medicalActionsStore'])
            ->name('medical-actions.store');

        // RESEP & OBAT
        Route::get('/rekam-medis/{medicalRecordId}/resep',
            [DashboardController::class, 'prescriptions'])
            ->name('prescriptions.index');

        Route::post('/rekam-medis/{medicalRecordId}/resep',
            [DashboardController::class, 'prescriptionsStore'])
            ->name('prescriptions.store');
    });

    /*
    |--------------------------------------------------------------------------
    | NURSE
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:Nurse')->group(function () {

        // DASHBOARD
        Route::get('/dashboard-nurse', [DashboardController::class, 'nurse'])
            ->name('dashboard.nurse');

        // PASIEN (READ)
        Route::get('/pasien/nurse', [DashboardController::class, 'patientsNurse'])
            ->name('patients.nurse');

        // REGISTRASI & ANTRIAN
        Route::get('/registrasi-nurse', [DashboardController::class, 'registrationsNurse'])
            ->name('registrations.nurse');

        /*
        |--------------------------------------------------------------------------
        | VITAL SIGN
        |--------------------------------------------------------------------------
        */
        Route::get('/vital-sign/{registrationId}',
            [DashboardController::class, 'vitalCreate'])
            ->name('vital.create');

        Route::post('/vital-sign/{registrationId}',
            [DashboardController::class, 'vitalStore'])
            ->name('vital.store');

        // KIRIM KE DOKTER
        Route::post('/registrasi/{id}/kirim-dokter',
            [DashboardController::class, 'sendToDoctor'])
            ->name('registrations.sendDoctor');
    });

    /*
    |--------------------------------------------------------------------------
    | REKAM MEDIS - SHARED (ADMIN + DOCTOR)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:Admin,Doctor')->group(function () {

        // LIST REKAM MEDIS
        Route::get('/rekam-medis',
            [DashboardController::class, 'medicalRecordsIndex'])
            ->name('medical-records.index');

        // DETAIL (jika ada)
        Route::get('/rekam-medis/{medicalRecordId}',
            [DashboardController::class, 'medicalRecordsShow'])
            ->name('medical-records.show');

        // TINDAKAN MEDIS (READ)
        Route::get('/rekam-medis/{medicalRecordId}/tindakan',
            [DashboardController::class, 'medicalActions'])
            ->name('medical-actions.index');

        // RESEP (READ)
        Route::get('/rekam-medis/{medicalRecordId}/resep',
            [DashboardController::class, 'prescriptions'])
            ->name('prescriptions.index');
    });


    /*
    |--------------------------------------------------------------------------
    | REKAM MEDIS - DOCTOR ONLY (WRITE)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:Doctor')->group(function () {

        Route::get('/rekam-medis/{registrationId}/create',
            [DashboardController::class, 'medicalRecordsCreate'])
            ->name('medical-records.create');

        Route::post('/rekam-medis/{registrationId}',
            [DashboardController::class, 'medicalRecordsStore'])
            ->name('medical-records.store');

        Route::post('/rekam-medis/{medicalRecordId}/tindakan',
            [DashboardController::class, 'medicalActionsStore'])
            ->name('medical-actions.store');

        Route::post('/rekam-medis/{medicalRecordId}/resep',
            [DashboardController::class, 'prescriptionsStore'])
            ->name('prescriptions.store');
    });

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
