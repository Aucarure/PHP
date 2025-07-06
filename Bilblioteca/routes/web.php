<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookReaderController;
use App\Http\Controllers\AdminController;
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

    // Rutas del lector de libros - ACTUALIZADAS PARA VISOR DE PDF
    Route::get('/reader/{book}', [BookReaderController::class, 'show'])->name('reader.show');
    Route::post('/reader/{book}/progress', [BookReaderController::class, 'updateProgress'])->name('reader.progress');
    Route::post('/reader/{book}/bookmark', [BookReaderController::class, 'addBookmark'])->name('reader.bookmark');
    Route::post('/reader/{book}/completed', [BookReaderController::class, 'markCompleted'])->name('reader.completed');
});

// Rutas de Administración (protegidas por middleware admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard principal
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestión de libros - COMPLETA
    Route::get('/books', [AdminController::class, 'books'])->name('books');
    Route::post('/books', [AdminController::class, 'booksStore'])->name('books.store');
    Route::get('/books/{book}/edit', [AdminController::class, 'booksEdit'])->name('books.edit');
    Route::put('/books/{book}', [AdminController::class, 'booksUpdate'])->name('books.update');
    Route::delete('/books/{book}', [AdminController::class, 'booksDestroy'])->name('books.destroy');
    Route::post('/books/bulk-action', [AdminController::class, 'bulkAction'])->name('books.bulk');
    
    // Gestión de usuarios - SÚPER COMPLETA
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'usersStore'])->name('users.store');
    Route::get('/users/{user}', [AdminController::class, 'usersShow'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'usersEdit'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'usersUpdate'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'usersDestroy'])->name('users.destroy');
    Route::patch('/users/{user}/role', [AdminController::class, 'usersChangeRole'])->name('users.role');
    
    // Gestión de órdenes - SÚPER COMPLETA
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [AdminController::class, 'orderShow'])->name('orders.show');
    Route::get('/orders/{order}/print', [AdminController::class, 'orderPrint'])->name('orders.print');
    Route::patch('/orders/{order}/status', [AdminController::class, 'orderUpdateStatus'])->name('orders.status');
    Route::get('/orders/export/csv', [AdminController::class, 'ordersExport'])->name('orders.export');
    Route::get('/orders/{order}/details', [AdminController::class, 'orderDetails'])->name('orders.details');
    
    // Reportes - COMPLETO
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/reports/export', [AdminController::class, 'reportsExport'])->name('reports.export');
    
    // API auxiliares
    Route::get('/api/categories', [AdminController::class, 'getCategories'])->name('api.categories');
});

require __DIR__.'/auth.php';