<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

Route::get('/', [ProductController::class, 'welcome'])->name('home');

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/dashboard', function () {
    // Si c'est l'admin qui se connecte, on l'envoie vers SON index
    if (auth()->user()->is_admin) {
        return redirect()->route('products.index');
    }
    // Si c'est un client, on le ramène sur l'accueil
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/products/{id}/send', [ProductController::class, 'sendByEmail'])->name('products.send');
});

Route::middleware(['auth','admin'])->prefix('admin')->group(function () {
    Route::resource('products', ProductController::class)->except(['show']);
});

Route::get('/forcer-le-mot-de-passe', function () {
    $user = User::where('email', 'gerardobavi06@gmail.com')->first();
    
    if ($user) {
        $user->password = Hash::make('password'); // Le mot de passe sera : password
        $user->save();
        return "Le mot de passe a été mis à jour avec succès ! Connectez-vous sur /login";
    }

    return "Utilisateur non trouvé. Vérifiez l'email.";
});
Route::get('/test-route', function () {
    return "La route fonctionne bien !";
});


require __DIR__.'/auth.php';
