<?php

    use App\Http\Controllers\FuzzySeleksiController;
    use App\Http\Controllers\KandidatController;
    use App\Http\Controllers\PostDashboardController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\TesOnlineController;
    use App\Http\Controllers\UjianController;
    use App\Models\Post;
    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('home', [
            'title' => 'Home Page',
            'description' => 'Welcome to our website! This is the home page where you can find the latest updates and information about our services.'
        ]);
    });

    Route::get('/posts', function () {
        $posts = Post::latest()->filter(request(['search', 'category', 'author']))
            ->paginate(6)->withQueryString();

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

    // Ujian
    Route::get('/ujian', function () {
        return view('ujian', [
            'title' => 'Ujian',
            'description' => 'Halaman Ujian Online untuk Kandidat'
        ]);
    });
    Route::get('/ujian/{jenis}', [UjianController::class, 'show'])->name('ujian.tes');
    Route::post('/ujian/{jenis}', [UjianController::class, 'submit'])->name('ujian.submit');

    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->middleware(['auth', 'verified'])->name('dashboard.index');

    Route::middleware(['auth', 'verified'])->group(function () {
        // Posting (dashboard)
        Route::get('/posting', [PostDashboardController::class, 'index'])->name('posting.index');
        Route::get('/posting/create', [PostDashboardController::class, 'create'])->name('posting.create');
        Route::post('/posting', [PostDashboardController::class, 'store'])->name('posting.store');
        Route::delete('/posting/{post:slug}', [PostDashboardController::class, 'destroy'])->name('posting.destroy');
        Route::get('/posting/{post:slug}/edit', [PostDashboardController::class, 'edit'])->name('posting.edit');
        Route::patch('/posting/{post:slug}', [PostDashboardController::class, 'update'])->name('posting.update');
        Route::get('/posting/{post:slug}', [PostDashboardController::class, 'show'])->name('posting.show');

        // CRUD Kandidat
        Route::resource('kandidat', KandidatController::class);

         Route::get('/seleksi/soal-online', function () {
            $q = request('q');
            $query = \App\Models\TesOnline::query();
            if ($q) {
                $query->where('pertanyaan', 'like', "%$q%");
            }
            $soals = $query->latest()->paginate(10);
            return view('seleksi.soal-online', compact('soals', 'q'));
        })->name('soal-online.index');

        // Tes Online (resource) — views: seleksi/tes-online.blade.php & seleksi/tes-online-form.blade.php
        Route::resource('tes-online', TesOnlineController::class)
            ->parameters(['tes-online' => 'tesOnline']);

        // Halaman seleksi lainnya (non-CRUD)
        Route::prefix('seleksi')->name('seleksi.')->group(function () {
            Route::view('/hasil-fuzzy', 'seleksi.hasil-fuzzy')->name('hasil-fuzzy');
            Route::view('/rule-fuzzy', 'seleksi.rule-fuzzy')->name('rule-fuzzy');
        });

        Route::get('/seleksi/hasil-fuzzy', [FuzzySeleksiController::class, 'index'])->name('seleksi.hasil-fuzzy');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__ . '/auth.php';
