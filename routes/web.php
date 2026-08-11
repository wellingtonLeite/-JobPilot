<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (!auth()->user()->profile) {
        return redirect()->route('onboarding');
    }

    $matches = \App\Models\JobMatch::with('jobPosting')
        ->where('user_id', auth()->id())
        ->orderBy('score', 'desc')
        ->take(10)
        ->get();
        
    return view('dashboard', compact('matches'));
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;

Route::middleware('auth')->group(function () {
    Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding');
    Route::post('/onboarding', [OnboardingController::class, 'store']);
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/admin/settings', [AdminController::class, 'index'])->name('admin.settings');
    Route::post('/admin/settings', [AdminController::class, 'store'])->name('admin.settings.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
