<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookReaderController;
use Illuminate\Support\Facades\Route;

// Página principal
Route::get('/', [BookController::class, 'home'])->name('home');

// Rutas de libros
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// Rutas adicionales de libros (útiles para funcionalidades futuras)
Route::get('/books/category/{category}', [BookController::class, 'getByCategory'])->name('books.category');
Route::get('/books/search', [BookController::class, 'search'])->name('books.search');

// Ruta de categorías
Route::get('/categories', function() {
    $categories = App\Models\Book::distinct()->pluck('category')->sort();
    return view('categories.index', compact('categories'));
})->name('categories.index');

Route::middleware('auth')->group(function () {
    // Ruta dashboard - redirige a libros después del login
    Route::get('/dashboard', function () {
        return redirect()->route('books.index');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas del carrito (simplificadas para libros digitales)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    
    // Rutas adicionales del carrito (para funcionalidades AJAX)
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/has-book/{book}', [CartController::class, 'hasBook'])->name('cart.hasBook');

    // Rutas de checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/go-to-library', [CheckoutController::class, 'goToLibrary'])->name('checkout.go-library');

    // Rutas de biblioteca
    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
    Route::post('/library/{userBook}/toggle-status', [LibraryController::class, 'toggleStatus'])->name('library.toggle-status');
    Route::post('/library/{userBook}/toggle-favorite', [LibraryController::class, 'toggleFavorite'])->name('library.toggle-favorite');
    Route::delete('/library/{userBook}', [LibraryController::class, 'destroy'])->name('library.destroy');

    // Rutas del lector de libros
    Route::get('/reader/{book}', [BookReaderController::class, 'show'])->name('reader.show');
    Route::post('/reader/{book}/progress', [BookReaderController::class, 'updateProgress'])->name('reader.progress');
    Route::post('/reader/{book}/bookmark', [BookReaderController::class, 'addBookmark'])->name('reader.bookmark');
});

require __DIR__.'/auth.php';