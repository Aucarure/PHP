<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Mostrar formulario de checkout
     */
    public function index()
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->with('book')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->book->price * $item->quantity;
        });

        return view('checkout.index', compact('cartItems', 'total'));
    }

    /**
     * Procesar la compra
     */
    public function process(Request $request)
    {
        try {
            $user = Auth::user();
            $cartItems = CartItem::where('user_id', $user->id)->with('book')->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
            }

            // Debug: Verificar items del carrito
            \Log::info('Items en carrito:', ['count' => $cartItems->count()]);

            $total = $cartItems->sum(function ($item) {
                return $item->book->price * $item->quantity;
            });

            \Log::info('Total calculado:', ['total' => $total]);

            // Crear orden
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'completed', // Para libros digitales, completamos inmediatamente
                'shipping_address' => $request->country, // Usar este campo para el país
            ]);

            \Log::info('Orden creada:', ['order_id' => $order->id]);

            // Crear order_items y agregar libros a la biblioteca del usuario
            foreach ($cartItems as $cartItem) {
                \Log::info('Procesando item:', ['book_id' => $cartItem->book_id, 'quantity' => $cartItem->quantity]);

                // Crear registro en order_items
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $cartItem->book_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->book->price,
                ]);

                // Agregar libro a la biblioteca del usuario
                UserBook::create([
                    'user_id' => $user->id,
                    'book_id' => $cartItem->book_id,
                    'purchased_at' => now(),
                ]);

                \Log::info('UserBook creado para usuario:', ['user_id' => $user->id, 'book_id' => $cartItem->book_id]);
            }

            // Limpiar carrito
            CartItem::where('user_id', $user->id)->delete();
            \Log::info('Carrito limpiado');

            return redirect()->route('checkout.success', $order->id)->with('success', '¡Compra realizada exitosamente! Los libros han sido agregados a tu biblioteca.');

        } catch (\Exception $e) {
            \Log::error('Error en checkout:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('cart.index')->with('error', 'Hubo un error al procesar tu compra. Por favor, inténtalo de nuevo.');
        }
    }

    /**
     * Mostrar página de éxito después de la compra
     */
    public function success(Order $order)
    {
        // Verificar que la orden pertenece al usuario autenticado
        if ($order->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver esta orden.');
        }

        return view('checkout.success', compact('order'));
    }

    /**
     * Redireccionar a la biblioteca
     */
    public function goToLibrary()
    {
        return redirect()->route('library.index');
    }
}