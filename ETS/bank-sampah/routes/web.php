   <?php

   use App\Http\Controllers\JenisSampahController;
   use App\Http\Controllers\NasabahController;
   use App\Http\Controllers\ProfileController;
   use Illuminate\Support\Facades\Route;

   Route::redirect('/', '/dashboard');

   Route::get('/dashboard', fn () => view('dashboard'))
       ->middleware('auth')->name('dashboard');

   Route::middleware('auth')->group(function () {
       Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
       Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
       Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

       Route::resource('nasabah', NasabahController::class);
       Route::resource('jenis-sampah', JenisSampahController::class)->only(['index']);

       Route::middleware('role:admin')->group(function () {
           Route::resource('jenis-sampah', JenisSampahController::class)
               ->except(['index', 'show']);
       });
   });

   require __DIR__.'/auth.php';