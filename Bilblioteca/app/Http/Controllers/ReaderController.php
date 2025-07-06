<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\UserBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReaderController extends Controller
{
    /**
     * Mostrar el visor de PDF
     */
    public function show(Book $book)
    {
        // Verificar que el usuario tenga acceso al libro
        $userBook = UserBook::where('user_id', Auth::id())
                           ->where('book_id', $book->id)
                           ->first();

        if (!$userBook) {
            return redirect()->route('books.show', $book)
                           ->with('error', 'Necesitas comprar este libro para leerlo.');
        }

        // Verificar que el libro tenga un archivo PDF
        if (!$book->hasPdf()) {
            return redirect()->route('library.index')
                           ->with('error', 'Este libro no tiene un archivo PDF disponible.');
        }

        return view('reader.show', compact('book', 'userBook'));
    }

    /**
     * Guardar progreso de lectura
     */
    public function saveProgress(Request $request, $bookId)
    {
        $request->validate([
            'current_page' => 'required|integer|min:1',
            'total_pages' => 'required|integer|min:1'
        ]);

        $userBook = UserBook::where('book_id', $bookId)
                           ->where('user_id', Auth::id())
                           ->first();

        if (!$userBook) {
            return response()->json(['success' => false, 'message' => 'Libro no encontrado'], 404);
        }

        // Actualizar progreso usando el método existente
        $userBook->updateProgress($request->current_page, $request->total_pages);

        return response()->json([
            'success' => true,
            'progress_percentage' => $userBook->progress_percentage,
            'status' => $userBook->status
        ]);
    }

    /**
     * Marcar libro como completado
     */
    public function markCompleted(Request $request, $bookId)
    {
        $userBook = UserBook::where('book_id', $bookId)
                           ->where('user_id', Auth::id())
                           ->first();

        if (!$userBook) {
            return response()->json(['success' => false, 'message' => 'Libro no encontrado'], 404);
        }

        // Marcar como completado
        $userBook->update([
            'status' => 'read',
            'completed_at' => now(),
            'progress_percentage' => 100
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Agregar marcador
     */
    public function addBookmark(Request $request, $bookId)
    {
        $request->validate([
            'page' => 'required|integer|min:1',
            'title' => 'required|string|max:255'
        ]);

        $userBook = UserBook::where('book_id', $bookId)
                           ->where('user_id', Auth::id())
                           ->first();

        if (!$userBook) {
            return response()->json(['success' => false, 'message' => 'Libro no encontrado'], 404);
        }

        // Obtener marcadores existentes
        $bookmarks = $userBook->bookmarks ?? [];
        
        // Agregar nuevo marcador
        $bookmarks[] = [
            'page' => $request->page,
            'title' => $request->title,
            'created_at' => now()->toISOString()
        ];

        $userBook->update(['bookmarks' => $bookmarks]);

        return response()->json(['success' => true]);
    }
}