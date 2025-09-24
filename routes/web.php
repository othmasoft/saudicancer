<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HopeController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\FutureController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\QuestionController;

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');
    // Future Page
    Route::prefix('future')->name('future.')->group(function () {
    Route::get('/', [FutureController::class, 'index'])->name('index');
    Route::get('/show', [FutureController::class, 'show'])->name('show');
    Route::get('/create', [FutureController::class, 'create'])->name('create');
    Route::post('/store', [FutureController::class, 'store'])->name('store');
    Route::get('/{id}', [FutureController::class, 'view'])->name('view');
    Route::post('/search', [FutureController::class, 'searchByEmail'])->name('search');
    Route::post('/preview', [FutureController::class, 'preview'])->name('preview');
});

// Hope Page
Route::get('/hope/create', [HopeController::class, 'create'])->name('hope.create');
Route::get('/hope/show', [HopeController::class, 'show'])->name('hope.show');
Route::post('/hope/add-hand', function (\Illuminate\Http\Request $request) {
    event(new \App\Events\NewHandAdded($request->hand ?? '🖐️'));
    return response()->json(['status' => 'sent']);
});


// Questions Routes
Route::prefix('questions')->name('questions.')->group(function () {

    // Public routes
    Route::get('/', [QuestionController::class, 'index'])->name('index');
    Route::get('/random', [QuestionController::class, 'random'])->name('random');
    Route::get('/quiz', [QuestionController::class, 'quiz'])->name('quiz');
    Route::post('/quiz/submit', [QuestionController::class, 'submitQuiz'])->name('quiz.submit');
    Route::get('/{id}', [QuestionController::class, 'show'])->name('show');
    Route::post('/{id}/check', [QuestionController::class, 'checkAnswer'])->name('check');

    // API routes
    Route::get('/api/stats', [QuestionController::class, 'getStats'])->name('api.stats');
});

// Support Page
Route::get('/support', [SupportController::class, 'index'])->name('support.index');
Route::get('/support/create', [SupportController::class, 'create'])->name('support.create');
Route::get('/support/prince', [SupportController::class, 'prince'])->name('support.prince');
Route::post('/support', [SupportController::class, 'store'])->name('support.store');
Route::get('/support/show', [SupportController::class, 'show'])->name('support.show');
Route::get('/support/{id}', [SupportController::class, 'view'])->name('support.view');
Route::post('/support/search', [SupportController::class, 'searchByEmail'])->name('support.search');




// Admin routes (protected by auth and admin middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/support', [SupportController::class, 'adminIndex'])->name('admin.support.index');
    Route::patch('/admin/support/{id}/status', [SupportController::class, 'updateStatus'])->name('admin.support.status');
    Route::post('/admin/support/{id}/response', [SupportController::class, 'addResponse'])->name('admin.support.response');
    Route::delete('/admin/support/{id}', [SupportController::class, 'destroy'])->name('admin.support.delete');
    Route::get('/admin/support/stats', [SupportController::class, 'getStats'])->name('admin.support.stats');
});

// Products Resource
//Route::resource('products', ProductController::class);
