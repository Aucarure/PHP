<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cartItems = Auth::user()->cartItems()->with('book')->get();
        
        // Para libros digitales, cada item tiene cantidad 1
        // Calculamos el total sumando directamente los precios
        $total = $cartItems->sum(function($item) {
            return $item->book->price;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Book $book, Request $request)
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Verificar si el libro ya está en el carrito
        $existingCartItem = CartItem::where('user_id', $user->id)
                                   ->where('book_id', $book->id)
                                   ->first();

        if ($existingCartItem) {
            // Para libros digitales, no permitimos duplicados
            return redirect()->back()->with('info', 'Este libro ya está en tu carrito');
        }

        // Crear nuevo item en el carrito (siempre cantidad 1 para libros digitales)
        CartItem::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'quantity' => 1, // Siempre 1 para libros digitales
        ]);

        return redirect()->back()->with('success', 'Libro agregado al carrito');
    }

    public function remove(CartItem $cartItem)
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Verificar que el item del carrito pertenece al usuario autenticado
        if ($cartItem->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para eliminar este item.');
        }

        $bookTitle = $cartItem->book->title;
        $cartItem->delete();

        return redirect()->route('cart.index')
               ->with('success', "'{$bookTitle}' ha sido eliminado del carrito");
    }

    // Método para obtener el número de items en el carrito (útil para el badge del nav)
    public function getCartCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Auth::user()->cartItems()->count();
        
        return response()->json(['count' => $count]);
    }

    // Método para limpiar todo el carrito
    public function clear()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        Auth::user()->cartItems()->delete();

        return redirect()->route('cart.index')
               ->with('success', 'Carrito vaciado completamente');
    }

    // Método para verificar si un libro específico está en el carrito
    public function hasBook(Book $book)
    {
        if (!Auth::check()) {
            return response()->json(['inCart' => false]);
        }

        $inCart = CartItem::where('user_id', Auth::id())
                         ->where('book_id', $book->id)
                         ->exists();

        return response()->json(['inCart' => $inCart]);
    }
}