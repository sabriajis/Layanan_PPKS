<?php


use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PengaduanUserController;
use App\Http\Controllers\DashboardController;


//Route untuk register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);


// Route untuk halaman login
Route::get('/', function () {
    // Mengambil data pengguna dengan role
    $users = User::with('roles')->paginate(10);
    return view('pages.auth.auth-login');
});


// Rute yang hanya bisa diakses oleh pengguna yang terautentikasi

Route::middleware(['auth'])->group(function () {

    // Dashboard route
    Route::get('home', [DashboardController::class, 'index'])->name('home');

    // Route manajemen user, hanya bisa diakses oleh admin
    Route::middleware(['role:admin|anggota'])->group(function () {
        Route::resource('user', UserController::class);
    });

    // Route manajemen pengaduan, bisa diakses oleh admin dan anggota
    Route::middleware(['role:anggota|admin'])->group(function () {
        Route::resource('pengaduan', PengaduanController::class);
        Route::post('/pengaduan/{id}/update-status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.updateStatus');
     });


     Route::middleware(['auth', 'role:user'])->group(function () {
        Route::get('/pengaduanuser', [PengaduanUserController::class, 'index'])->name('pengaduanuser.index');
        Route::get('/pengaduanuser/create', [PengaduanUserController::class, 'create'])->name('pengaduanuser.create');
        Route::post('/pengaduanuser/store', [PengaduanUserController::class, 'store'])->name('pengaduanuser.store');
        Route::get('/pengaduanuser/{id}', [PengaduanUserController::class, 'show'])->name('pengaduanuser.show');
      });



    // // Route tambahan yang hanya bisa diakses oleh pengguna dengan permission 'edit users'
    // Route::group(['middleware' => ['permission:edit users']], function () {
    //     Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    // });
});
