<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\PackageController;
use App\Http\Middleware\VerifyRole;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');;
Route::get('/', [HomeController::class, 'index'])->name('home');
// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/password/reset', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::get('/content/{content}/download', [ContentController::class, 'download'])->name('content.download');
    // Route to redirect users based on their role
    Route::get('/home', function() {
        $role = auth()->user()->role;
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'school') return redirect()->route('school.dashboard');
        return redirect()->route('dashboard');
    });
    Route::get('/lesson-plan', [LessonController::class, 'index'])->name('content.lesson-plan');
    Route::get('/create-lesson-plan', [LessonController::class, 'create'])->name('content.create.lesson-plan');
    Route::post('/lesson-plan', [ContentController::class, 'lessonPlan']);

    Route::get('/resources', [ResourceController::class, 'index'])->name('content.resource');
    Route::get('/create-resource', [ResourceController::class, 'create'])->name('content.create.resource');
    Route::post('/resources', [ContentController::class, 'resourceKit']);

    Route::get('/quizzes', [QuizController::class, 'index'])->name('content.quiz');
    Route::get('/create-quiz', [QuizController::class, 'create'])->name('content.create.quiz');
    Route::post('/quizzes', [ContentController::class, 'quiz'])->name('quizzes.store');

    Route::get('/assignments', [AssignmentController::class, 'index'])->name('content.assignment');
    Route::get('/create-assignment', [AssignmentController::class, 'create'])->name('content.create.assignment');
    Route::post('/assignment', [ContentController::class, 'assignment'])->name('assignment.store');

    Route::get('/content/{content}/export/pdf', [ContentController::class, 'exportPdf'])->name('content.export.pdf');

    Route::get('/content/{id}/view', [ContentController::class, 'view'])->name('content.view');
    Route::delete('/content/{id}', [ContentController::class, 'destroy'])->name('content.destroy');

    // Direct use of middleware class instead of alias
    
    // Teacher and User Routes
    Route::middleware(VerifyRole::class . ':teacher')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.teacher');
      
    });

    // Admin Routes
    Route::middleware(VerifyRole::class . ':admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.update.user');

         // Package routes
    Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
    Route::get('/packages/create', [PackageController::class, 'create'])->name('packages.create');
    Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
    Route::get('/packages/{package}/edit', [PackageController::class, 'edit'])->name('packages.edit');
    Route::put('/packages/{package}', [PackageController::class, 'update'])->name('packages.update');
    Route::delete('/packages/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');
    
    // AJAX routes for status updates
    Route::put('/packages/{package}/update-status', [PackageController::class, 'updateStatus'])
        ->name('packages.update-status');
    Route::put('/packages/{package}/feature-update-status', [PackageController::class, 'featureupdateStatus'])
        ->name('packages.feature-update-status');
    });



    //School  Routes
    Route::middleware(['auth', VerifyRole::class . ':school'])->group(function () {
        Route::get('/school/dashboard', [SchoolController::class, 'index'])->name('school.dashboard');
    
        // Manage teachers
        Route::get('/school/teachers', [SchoolController::class, 'listTeachers'])->name('school.teachers.index');
        Route::get('/school/teachers/create', [SchoolController::class, 'createTeacher'])->name('school.teachers.create');
        Route::post('/school/teachers', [SchoolController::class, 'storeTeacher'])->name('school.teachers.store');
        Route::get('/school/teachers/{teacher}/edit', [SchoolController::class, 'editTeacher'])->name('school.teachers.edit');
        Route::put('/school/teachers/{teacher}', [SchoolController::class, 'updateTeacher'])->name('school.teachers.update');
        Route::delete('/school/teachers/{teacher}', [SchoolController::class, 'deleteTeacher'])->name('school.teachers.delete');

        

        //subscription 
        Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::controller(StripePaymentController::class)->group(function () {
            Route::get('stripe/{packageId}', 'stripe')->name('stripe.payment');
            Route::post('stripe/{packageId}', 'stripePost')->name('stripe.post');
            Route::post('/renew-package', 'stripeRenew')->name('stripe.renew');
            Route::post('/auto-renew-payment', 'autoRenewPayment')->name('auto.renew.payment');
            Route::post('/cancel-subscription', 'cancelSubscription')->name('cancel.subscription');
            Route::post('/package/free-activate/{packageId}',  'activateFreePackage')->name('package.free.activate');

        
        });

    });
    
});