<?php

namespace App\Http\Controllers;

use App\Models\UserBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    public function index()
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userBooks = UserBook::where('user_id', $user->id)
                            ->with('book')
                            ->orderBy('purchased_at', 'desc')
                            ->get();

        $totalBooks = $userBooks->count();
        $readBooks = $userBooks->where('status', 'read')->count();
        $pendingBooks = $userBooks->where('status', 'pending')->count();
        $favoriteBooks = $userBooks->where('is_favorite', true)->count();

        return view('library.index', compact(
            'userBooks', 
            'totalBooks', 
            'readBooks', 
            'pendingBooks', 
            'favoriteBooks'
        ));
    }

    public function toggleStatus(UserBook $userBook)
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return response()->json(['success' => false], 401);
        }

        // Verificar que el libro pertenezca al usuario autenticado
        if ($userBook->user_id !== Auth::id()) {
            return response()->json(['success' => false], 403);
        }

        $userBook->status = $userBook->status === 'read' ? 'pending' : 'read';
        $userBook->save();

        return response()->json(['success' => true, 'status' => $userBook->status]);
    }

    public function toggleFavorite(UserBook $userBook)
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return response()->json(['success' => false], 401);
        }

        // Verificar que el libro pertenezca al usuario autenticado
        if ($userBook->user_id !== Auth::id()) {
            return response()->json(['success' => false], 403);
        }

        $userBook->is_favorite = !$userBook->is_favorite;
        $userBook->save();

        return response()->json(['success' => true, 'is_favorite' => $userBook->is_favorite]);
    }

    public function destroy(UserBook $userBook)
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return response()->json(['success' => false], 401);
        }

        // Verificar que el libro pertenezca al usuario autenticado
        if ($userBook->user_id !== Auth::id()) {
            return response()->json(['success' => false], 403);
        }

        $userBook->delete();

        return response()->json(['success' => true]);
    }
}