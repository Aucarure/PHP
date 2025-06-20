<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        // Filtrar por categoría
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Búsqueda por título o autor
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('author', 'like', $searchTerm);
            });
        }

        // Ordenar por más recientes
        $query->orderBy('created_at', 'desc');

        $books = $query->paginate(12);
        $categories = Book::distinct()->pluck('category')->sort();

        // Debug: verificar si hay libros
        if ($books->count() == 0) {
            $totalBooks = Book::count();
            if ($totalBooks == 0) {
                // No hay libros en la base de datos
                return view('books.index', compact('books', 'categories'))
                    ->with('debug', 'No hay libros en la base de datos. Ejecuta el seeder.');
            }
        }

        return view('books.index', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        // Para libros digitales, no necesitamos verificar stock
        // Solo mostramos el libro
        return view('books.show', compact('book'));
    }

    // Método para la página principal
    public function home()
    {
        // Optimización: limitar la cantidad de libros para la página principal
        // y solo obtener los campos necesarios para mejorar el rendimiento
        $books = Book::select('id', 'title', 'author', 'price', 'category', 'image')
                    ->latest()
                    ->take(8) // Limitar a 8 libros más recientes
                    ->get();
                    
        return view('home', compact('books'));
    }

    // Método para obtener libros por categoría (útil para AJAX)
    public function getByCategory($category)
    {
        $books = Book::where('category', $category)
                    ->orderBy('created_at', 'desc')
                    ->get();
                    
        return response()->json($books);
    }

    // Método para búsqueda rápida (útil para autocomplete)
    public function search(Request $request)
    {
        $searchTerm = $request->get('q');
        
        if (strlen($searchTerm) < 2) {
            return response()->json([]);
        }

        $books = Book::select('id', 'title', 'author', 'price', 'image')
                    ->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('author', 'like', '%' . $searchTerm . '%')
                    ->limit(5)
                    ->get();

        return response()->json($books);
    }
}