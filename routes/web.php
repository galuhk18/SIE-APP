<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [HomeController::class,'index'])->name('index');

Route::prefix('auth')->group(function () {
    Route::get('/admin/login',[AuthController::class,'admin_login'])->name('auth.admin.login');
    Route::post('/admin/login',[AuthController::class,'admin_login_validation'])->name('auth.admin.login.validation');
    Route::get('/admin/logout',[AuthController::class,'admin_logout'])->name('auth.admin.logout');

    Route::get('/executive/login',[AuthController::class,'executive_login'])->name('auth.executive.login');
    Route::post('/executive/login',[AuthController::class,'executive_login_validation'])->name('auth.executive.login.validation');
    Route::get('/executive/logout',[AuthController::class,'executive_logout'])->name('auth.executive.logout');
}); 

Route::prefix('dashboard')->middleware('auth.admin')->group(function () {
    
    Route::get('/',[AdminController::class,'index'])->name('admin.index');
    // Population
    Route::prefix('population')->group(function () {
        Route::get('/', [AdminController::class,'population_index'])->name('population.index');
        Route::get('/create', [AdminController::class,'population_create'])->name('population.create');
        Route::post('/create', [AdminController::class,'population_store'])->name('population.store');
        Route::get('/edit/{id}', [AdminController::class,'population_edit'])->name('population.edit');
        Route::put('/edit/{id}', [AdminController::class,'population_update'])->name('population.update');
        Route::get('/destroy/{id}', [AdminController::class,'population_destroy'])->name('population.destroy');
        Route::get('/export', [AdminController::class,'population_export'])->name('population.export');
        Route::get('/form/export', [AdminController::class,'population_form_export'])->name('population.form.export');
        Route::post('/import', [AdminController::class,'population_import'])->name('population.import');
    });
    // Birth
    Route::prefix('birth')->group(function () {
        Route::get('/', [AdminController::class,'birth_index'])->name('birth.index');
        Route::get('/create', [AdminController::class,'birth_create'])->name('birth.create');
        Route::post('/create', [AdminController::class,'birth_store'])->name('birth.store');
        Route::get('/edit/{id}', [AdminController::class,'birth_edit'])->name('birth.edit');
        Route::put('/edit/{id}', [AdminController::class,'birth_update'])->name('birth.update');
        Route::get('/destroy/{id}', [AdminController::class,'birth_destroy'])->name('birth.destroy');
        Route::get('/export', [AdminController::class,'birth_export'])->name('birth.export');
        Route::get('/form/export', [AdminController::class,'birth_form_export'])->name('birth.form.export');
        Route::post('/import', [AdminController::class,'birth_import'])->name('birth.import');
    });
    // Death
    Route::prefix('death')->group(function () {
        Route::get('/', [AdminController::class,'death_index'])->name('death.index');
        Route::get('/create', [AdminController::class,'death_create'])->name('death.create');
        Route::post('/create', [AdminController::class,'death_store'])->name('death.store');
        Route::get('/edit/{id}', [AdminController::class,'death_edit'])->name('death.edit');
        Route::put('/edit/{id}', [AdminController::class,'death_update'])->name('death.update');
        Route::get('/destroy/{id}', [AdminController::class,'death_destroy'])->name('death.destroy');
        Route::get('/export', [AdminController::class,'death_export'])->name('death.export');
        Route::get('/form/export', [AdminController::class,'death_form_export'])->name('death.form.export');
        Route::post('/import', [AdminController::class,'death_import'])->name('death.import');
    });
    // Decision
    Route::prefix('decision')->group(function () {
        Route::get('/', [AdminController::class,'decision_index'])->name('decision.index');
        Route::get('/create', [AdminController::class,'decision_create'])->name('decision.create');
        Route::post('/create', [AdminController::class,'decision_store'])->name('decision.store');
        Route::get('/edit/{id}', [AdminController::class,'decision_edit'])->name('decision.edit');
        Route::put('/edit/{id}', [AdminController::class,'decision_update'])->name('decision.update');
        Route::get('/destroy/{id}', [AdminController::class,'decision_destroy'])->name('decision.destroy');
        Route::get('/export', [AdminController::class,'decision_export'])->name('decision.export');
    });
    // Service
    Route::prefix('service')->group(function () {
        Route::get('/', [AdminController::class,'service_index'])->name('service.index');
        Route::get('/create', [AdminController::class,'service_create'])->name('service.create');
        Route::post('/create', [AdminController::class,'service_store'])->name('service.store');
        Route::get('/edit/{id}', [AdminController::class,'service_edit'])->name('service.edit');
        Route::put('/edit/{id}', [AdminController::class,'service_update'])->name('service.update');
        Route::get('/destroy/{id}', [AdminController::class,'service_destroy'])->name('service.destroy');
        Route::get('/export', [AdminController::class,'service_export'])->name('service.export');
    });
    // Activity
    Route::prefix('activity')->group(function () {
        Route::get('/', [AdminController::class,'activity_index'])->name('activity.index');
        Route::get('/create', [AdminController::class,'activity_create'])->name('activity.create');
        Route::post('/create', [AdminController::class,'activity_store'])->name('activity.store');
        Route::get('/edit/{id}', [AdminController::class,'activity_edit'])->name('activity.edit');
        Route::put('/edit/{id}', [AdminController::class,'activity_update'])->name('activity.update');
        Route::get('/destroy/{id}', [AdminController::class,'activity_destroy'])->name('activity.destroy');
        Route::get('/export', [AdminController::class,'activity_export'])->name('activity.export');
        Route::get('/form/export', [AdminController::class,'activity_form_export'])->name('activity.form.export');
        Route::post('/import', [AdminController::class,'activity_import'])->name('activity.import');
    });
    // Funding Petition
    Route::prefix('funding/petition')->group(function () {
        Route::get('/', [AdminController::class,'funding_petition_index'])->name('funding.petition.index');
        Route::get('/create', [AdminController::class,'funding_petition_create'])->name('funding.petition.create');
        Route::post('/create', [AdminController::class,'funding_petition_store'])->name('funding.petition.store');
        Route::get('/edit/{id}', [AdminController::class,'funding_petition_edit'])->name('funding.petition.edit');
        Route::put('/edit/{id}', [AdminController::class,'funding_petition_update'])->name('funding.petition.update');
        Route::get('/destroy/{id}', [AdminController::class,'funding_petition_destroy'])->name('funding.petition.destroy');
        Route::get('/export', [AdminController::class,'funding_petition_export'])->name('funding.petition.export');
    });
    // Activity Report
    Route::prefix('activity/report')->group(function () {
        Route::get('/', [AdminController::class,'activity_report_index'])->name('activity.report.index');
        Route::get('/create', [AdminController::class,'activity_report_create'])->name('activity.report.create');
        Route::post('/create', [AdminController::class,'activity_report_store'])->name('activity.report.store');
        Route::get('/edit/{id}', [AdminController::class,'activity_report_edit'])->name('activity.report.edit');
        Route::put('/edit/{id}', [AdminController::class,'activity_report_update'])->name('activity.report.update');
        Route::get('/destroy/{id}', [AdminController::class,'activity_report_destroy'])->name('activity.report.destroy');
        Route::get('/export', [AdminController::class,'activity_report_export'])->name('activity.report.export');
    });
    // Building Management
    Route::prefix('building/management')->group(function () {
        Route::get('/', [AdminController::class,'building_management_index'])->name('building.management.index');
        Route::get('/create', [AdminController::class,'building_management_create'])->name('building.management.create');
        Route::post('/create', [AdminController::class,'building_management_store'])->name('building.management.store');
        Route::get('/edit/{id}', [AdminController::class,'building_management_edit'])->name('building.management.edit');
        Route::put('/edit/{id}', [AdminController::class,'building_management_update'])->name('building.management.update');
        Route::get('/destroy/{id}', [AdminController::class,'building_management_destroy'])->name('building.management.destroy');
        Route::get('/export', [AdminController::class,'building_management_export'])->name('building.management.export');
    });
    // Facility Management
    Route::prefix('facility/management')->group(function () {
        Route::get('/', [AdminController::class,'facility_management_index'])->name('facility.management.index');
        Route::get('/create', [AdminController::class,'facility_management_create'])->name('facility.management.create');
        Route::post('/create', [AdminController::class,'facility_management_store'])->name('facility.management.store');
        Route::get('/edit/{id}', [AdminController::class,'facility_management_edit'])->name('facility.management.edit');
        Route::put('/edit/{id}', [AdminController::class,'facility_management_update'])->name('facility.management.update');
        Route::get('/destroy/{id}', [AdminController::class,'facility_management_destroy'])->name('facility.management.destroy');
        Route::get('/export', [AdminController::class,'facility_management_export'])->name('facility.management.export');
    });
    // Building Rental
    Route::prefix('building/rental')->group(function () {
        Route::get('/', [AdminController::class,'building_rental_index'])->name('building.rental.index');
        Route::get('/create', [AdminController::class,'building_rental_create'])->name('building.rental.create');
        Route::post('/create', [AdminController::class,'building_rental_store'])->name('building.rental.store');
        Route::get('/edit/{id}', [AdminController::class,'building_rental_edit'])->name('building.rental.edit');
        Route::put('/edit/{id}', [AdminController::class,'building_rental_update'])->name('building.rental.update');
        Route::get('/destroy/{id}', [AdminController::class,'building_rental_destroy'])->name('building.rental.destroy');
        Route::get('/export', [AdminController::class,'building_rental_export'])->name('building.rental.export');
    });
    // Facility Rental
    Route::prefix('facility/rental')->group(function () {
        Route::get('/', [AdminController::class,'facility_rental_index'])->name('facility.rental.index');
        Route::get('/create', [AdminController::class,'facility_rental_create'])->name('facility.rental.create');
        Route::post('/create', [AdminController::class,'facility_rental_store'])->name('facility.rental.store');
        Route::get('/edit/{id}', [AdminController::class,'facility_rental_edit'])->name('facility.rental.edit');
        Route::put('/edit/{id}', [AdminController::class,'facility_rental_update'])->name('facility.rental.update');
        Route::get('/destroy/{id}', [AdminController::class,'facility_rental_destroy'])->name('facility.rental.destroy');
        Route::get('/export', [AdminController::class,'facility_rental_export'])->name('facility.rental.export');
    });
    // Facility Compensation
    Route::prefix('facility/compensation')->group(function () {
        Route::get('/', [AdminController::class,'facility_compensation_index'])->name('facility.compensation.index');
        Route::get('/create', [AdminController::class,'facility_compensation_create'])->name('facility.compensation.create');
        Route::post('/create', [AdminController::class,'facility_compensation_store'])->name('facility.compensation.store');
        Route::get('/edit/{id}', [AdminController::class,'facility_compensation_edit'])->name('facility.compensation.edit');
        Route::put('/edit/{id}', [AdminController::class,'facility_compensation_update'])->name('facility.compensation.update');
        Route::get('/destroy/{id}', [AdminController::class,'facility_compensation_destroy'])->name('facility.compensation.destroy');
        Route::get('/export', [AdminController::class,'facility_compensation_export'])->name('facility.compensation.export');
    });
    // User Executive
    Route::prefix('user/executive')->group(function () {
        Route::get('/', [AdminController::class,'user_executive_index'])->name('user.executive.index');
        Route::get('/create', [AdminController::class,'user_executive_create'])->name('user.executive.create');
        Route::post('/create', [AdminController::class,'user_executive_store'])->name('user.executive.store');
        Route::get('/edit/{id}', [AdminController::class,'user_executive_edit'])->name('user.executive.edit');
        Route::put('/edit/{id}', [AdminController::class,'user_executive_update'])->name('user.executive.update');
        Route::get('/pass/{id}', [AdminController::class,'user_executive_pass'])->name('user.executive.pass');
        Route::put('/pass/{id}', [AdminController::class,'user_executive_pass_act'])->name('user.executive.pass.act');
        Route::get('/destroy/{id}', [AdminController::class,'user_executive_destroy'])->name('user.executive.destroy');
        Route::get('/profile', [AdminController::class,'user_executive_profile'])->name('user.executive.profile');
    });
    // User admin
    Route::prefix('user/admin')->group(function () {
        Route::get('/', [AdminController::class,'user_admin_index'])->name('user.admin.index');
        Route::get('/create', [AdminController::class,'user_admin_create'])->name('user.admin.create');
        Route::post('/create', [AdminController::class,'user_admin_store'])->name('user.admin.store');
        Route::get('/edit/{id}', [AdminController::class,'user_admin_edit'])->name('user.admin.edit');
        Route::put('/edit/{id}', [AdminController::class,'user_admin_update'])->name('user.admin.update');
        Route::get('/pass/{id}', [AdminController::class,'user_admin_pass'])->name('user.admin.pass');
        Route::put('/pass/{id}', [AdminController::class,'user_admin_pass_act'])->name('user.admin.pass.act');
        Route::get('/destroy/{id}', [AdminController::class,'user_admin_destroy'])->name('user.admin.destroy');
        Route::get('/profile', [AdminController::class,'user_admin_profile'])->name('user.admin.profile');
    });
});