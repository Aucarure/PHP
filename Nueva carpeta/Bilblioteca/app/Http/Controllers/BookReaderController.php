<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\UserBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookReaderController extends Controller
{
    /**
     * Mostrar el lector de libros
     */
    public function show(Book $book)
    {
        $user = Auth::user();
        
        // Verificar que el usuario tiene acceso al libro
        $userBook = UserBook::where('user_id', $user->id)
                           ->where('book_id', $book->id)
                           ->first();

        if (!$userBook) {
            return redirect()->route('books.show', $book)
                           ->with('error', 'No tienes acceso a este libro. Debes comprarlo primero.');
        }

        // Simular contenido del libro
        $bookContent = $this->generateBookContent($book);
        
        return view('reader.show', compact('book', 'userBook', 'bookContent'));
    }

    /**
     * Actualizar progreso de lectura via AJAX
     */
    public function updateProgress(Request $request, Book $book)
    {
        $user = Auth::user();
        
        $userBook = UserBook::where('user_id', $user->id)
                           ->where('book_id', $book->id)
                           ->first();

        if (!$userBook) {
            return response()->json(['error' => 'Libro no encontrado'], 404);
        }

        $currentPage = $request->input('current_page');
        $totalPages = $request->input('total_pages');

        $userBook->updateProgress($currentPage, $totalPages);

        return response()->json([
            'success' => true,
            'progress_percentage' => $userBook->progress_percentage,
            'status' => $userBook->status,
            'reading_status' => $userBook->reading_status
        ]);
    }

    /**
     * Agregar marcador
     */
    public function addBookmark(Request $request, Book $book)
    {
        $user = Auth::user();
        
        $userBook = UserBook::where('user_id', $user->id)
                           ->where('book_id', $book->id)
                           ->first();

        if (!$userBook) {
            return response()->json(['error' => 'Libro no encontrado'], 404);
        }

        $bookmarks = $userBook->bookmarks ?? [];
        $newBookmark = [
            'page' => $request->input('page'),
            'title' => $request->input('title', 'Marcador'),
            'created_at' => now()->toISOString(),
        ];

        $bookmarks[] = $newBookmark;
        $userBook->bookmarks = $bookmarks;
        $userBook->save();

        return response()->json(['success' => true, 'bookmark' => $newBookmark]);
    }

    /**
     * Generar contenido de ejemplo para el libro
     */
    private function generateBookContent($book)
    {
        $chapters = [
            [
                'title' => 'Introducción',
                'content' => 'Este es el contenido de la introducción del libro "' . $book->title . '". Aquí comenzamos nuestro viaje de aprendizaje con los conceptos fundamentales que serán la base para todo lo que aprenderemos a continuación.'
            ],
            [
                'title' => 'Capítulo 1: Fundamentos',
                'content' => 'En este primer capítulo, exploraremos los conceptos fundamentales que necesitas conocer. Estableceremos las bases sólidas que te permitirán avanzar con confianza hacia temas más complejos.'
            ],
            [
                'title' => 'Capítulo 2: Conceptos Avanzados',
                'content' => 'Ahora que hemos cubierto los fundamentos, es momento de adentrarnos en conceptos más avanzados. Aquí profundizaremos en técnicas y metodologías que te llevarán al siguiente nivel.'
            ],
            [
                'title' => 'Capítulo 3: Ejemplos Prácticos',
                'content' => 'La teoría está bien, pero la práctica es donde realmente se aprende. Veamos algunos ejemplos prácticos que te ayudarán a aplicar todo lo que has aprendido hasta ahora.'
            ],
            [
                'title' => 'Conclusiones',
                'content' => 'Para concluir este libro, repasemos los puntos más importantes que hemos aprendido. Este conocimiento te servirá como base para continuar tu desarrollo y crecimiento profesional.'
            ],
        ];

        return $chapters;
    }
}