<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostDashboardController;

Route::get('/', function () {
    return view('home', [
        'title' => 'Home Page',
        'description' => 'Welcome to our website! This is the home page where you can find the latest updates and information about our services.'
    ]);
});

Route::get('/posts', function () {
    // $posts = Post::with(['author', 'category'])->latest()->get();
    $posts = Post::latest()->filter(request(['search', 'category', 'author']))->paginate(6)->withQueryString();

    return view('posts', [
        'title' => 'Blog',
        'posts' => $posts
    ]);
});

Route::get('/posts/{post:slug}', function (Post $post) {
    return view('post', [
        'title' => 'Post Details',
        'post' => $post
    ]);
});

Route::get('/about', function () {
    return view('about', [
        'title' => 'About Us',
        'description' => 'Learn more about our website, our mission, and the team behind it.'
    ]);
});

Route::get('/contact', function () {
    return view('contact', [
        'title' => 'Contact Us',
        'description' => 'Get in touch with us through our contact form or find our contact details here.'
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard.index');



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/posting', [PostDashboardController::class, 'index'])
        ->name('posting.index');
    Route::get('/posting/create', [PostDashboardController::class, 'create'])
        ->name('posting.create');
    Route::post('/posting', [PostDashboardController::class, 'store'])
        ->name('posting.store');
    Route::delete('/posting/{post:slug}', [PostDashboardController::class, 'destroy'])
        ->name('posting.destroy');
    Route::get('/posting/{post:slug}/edit', [PostDashboardController::class, 'edit'])
        ->name('posting.edit');
    Route::patch('/posting/{post:slug}', [PostDashboardController::class, 'update'])
        ->name('posting.update');
    Route::get('/posting/{post:slug}', [PostDashboardController::class, 'show'])
        ->name('posting.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';
