<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalBooks = Book::count();
        $totalUsers = User::where('role', 'user')->count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total');

        $bestSellingBooks = collect([]);
        $monthlySales = collect([]);
        $popularCategories = collect([]);
        $recentUsers = User::where('role', 'user')->latest()->limit(5)->get();
        $recentOrders = Order::latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalUsers', 
            'totalOrders',
            'totalRevenue',
            'bestSellingBooks',
            'monthlySales',
            'popularCategories',
            'recentUsers',
            'recentOrders'
        ));
    }

    // ============ GESTIÓN DE LIBROS ============
    
    public function books(Request $request)
    {
        $query = Book::query();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filtro por categoría
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $books = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = Book::distinct()->pluck('category');

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function booksStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'file_path' => 'nullable|file|mimes:pdf|max:50000'
        ]);

        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->category = $request->category;
        $book->price = $request->price;
        $book->description = $request->description;
        $book->slug = Str::slug($request->title);

        // Manejar imagen de portada
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $book->cover_image = Storage::url($coverPath);
        }

        // Manejar archivo PDF
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('books', 'public');
            $book->file_path = Storage::url($filePath);
        }

        $book->save();

        return redirect()->route('admin.books')
                        ->with('success', 'Libro creado exitosamente');
    }

    public function booksEdit(Book $book)
    {
        return response()->json([
            'book' => $book
        ]);
    }

    public function booksUpdate(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'file_path' => 'nullable|file|mimes:pdf|max:50000'
        ]);

        $book->title = $request->title;
        $book->author = $request->author;
        $book->category = $request->category;
        $book->price = $request->price;
        $book->description = $request->description;
        $book->slug = Str::slug($request->title);

        // Actualizar imagen de portada
        if ($request->hasFile('cover_image')) {
            // Eliminar imagen anterior
            if ($book->cover_image) {
                $oldPath = str_replace('/storage/', '', $book->cover_image);
                Storage::disk('public')->delete($oldPath);
            }
            
            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $book->cover_image = Storage::url($coverPath);
        }

        // Actualizar archivo PDF
        if ($request->hasFile('file_path')) {
            // Eliminar archivo anterior
            if ($book->file_path) {
                $oldPath = str_replace('/storage/', '', $book->file_path);
                Storage::disk('public')->delete($oldPath);
            }
            
            $filePath = $request->file('file_path')->store('books', 'public');
            $book->file_path = Storage::url($filePath);
        }

        $book->save();

        return redirect()->route('admin.books')
                        ->with('success', 'Libro actualizado exitosamente');
    }

    public function booksDestroy(Book $book)
    {
        // Eliminar archivos asociados
        if ($book->cover_image) {
            $coverPath = str_replace('/storage/', '', $book->cover_image);
            Storage::disk('public')->delete($coverPath);
        }
        
        if ($book->file_path) {
            $filePath = str_replace('/storage/', '', $book->file_path);
            Storage::disk('public')->delete($filePath);
        }

        $book->delete();

        return redirect()->route('admin.books')
                        ->with('success', 'Libro eliminado exitosamente');
    }

    // ============ GESTIÓN DE USUARIOS ============
    
    public function users(Request $request)
    {
        $query = User::query();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'inactive') {
                $query->whereNull('email_verified_at');
            }
        }

        $users = $query->withCount(['orders', 'userBooks'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function usersStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => now(), // Auto-verificar usuarios creados por admin
        ]);

        return redirect()->route('admin.users')
                        ->with('success', 'Usuario creado exitosamente');
    }

    public function usersEdit(User $user)
    {
        return response()->json([
            'user' => $user
        ]);
    }

    public function usersUpdate(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin'
        ];

        // Solo validar contraseña si se proporciona
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Solo actualizar contraseña si se proporciona
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users')
                        ->with('success', 'Usuario actualizado exitosamente');
    }

    public function usersShow(User $user)
    {
        $user->load(['orders', 'userBooks']);
        
        $stats = [
            'total_orders' => $user->orders->count(),
            'total_spent' => $user->orders->where('status', 'completed')->sum('total'),
            'books_owned' => $user->userBooks->count(),
            'last_order' => $user->orders->first()
        ];

        return response()->json([
            'user' => $user,
            'stats' => $stats
        ]);
    }

    public function usersChangeRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin'
        ]);

        // Prevenir que el usuario se quite a sí mismo los permisos de admin
        if ($user->id === Auth::id() && $request->role === 'user') {
            return response()->json(['error' => 'No puedes quitarte a ti mismo los permisos de administrador'], 403);
        }

        $user->update(['role' => $request->role]);

        return response()->json(['message' => 'Rol actualizado exitosamente']);
    }

    public function usersDestroy(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.users')
                           ->with('error', 'No se puede eliminar un administrador');
        }

        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users')
                           ->with('error', 'No puedes eliminarte a ti mismo');
        }

        $user->delete();

        return redirect()->route('admin.users')
                        ->with('success', 'Usuario eliminado exitosamente');
    }

    // ============ GESTIÓN DE ÓRDENES ============
    
    public function orders(Request $request)
    {
        $query = Order::with(['user', 'orderItems']);

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por fecha
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $stats = [
            'total_orders' => Order::count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total')
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function orderShow(Order $order)
    {
        $order->load(['user', 'orderItems.book']);
        return view('admin.orders.show', compact('order'));
    }

    public function orderDetails(Order $order)
    {
        $order->load(['user', 'orderItems.book']);
        
        return response()->json([
            'order' => $order
        ]);
    }
    public function orderPrint(Order $order)
    {
        $order->load(['user', 'orderItems.book']);
        
        return view('admin.orders.print', compact('order'));
    }

    public function orderUpdateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Si se marca como completada, agregar libros a la biblioteca del usuario
        if ($request->status === 'completed' && $oldStatus !== 'completed') {
            foreach ($order->orderItems as $item) {
                $order->user->userBooks()->firstOrCreate([
                    'book_id' => $item->book_id
                ], [
                    'status' => 'not_started',
                    'progress' => 0,
                    'is_favorite' => false
                ]);
            }
        }

        return redirect()->route('admin.orders')
                        ->with('success', 'Estado de la orden actualizado exitosamente');
    }

    public function ordersExport(Request $request)
    {
        $orders = Order::with(['user', 'orderItems.book'])
                       ->orderBy('created_at', 'desc')
                       ->get();

        $filename = 'ordenes_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Headers del CSV
            fputcsv($file, [
                'ID',
                'Usuario',
                'Email',
                'Estado',
                'Total',
                'Items',
                'Libros',
                'Fecha'
            ]);

            // Datos
            foreach ($orders as $order) {
                $books = $order->orderItems->map(function($item) {
                    return ($item->book ? $item->book->title : 'Libro eliminado') . ' (x' . $item->quantity . ')';
                })->implode(', ');

                fputcsv($file, [
                    $order->id,
                    $order->user ? $order->user->name : 'Usuario eliminado',
                    $order->user ? $order->user->email : 'N/A',
                    ucfirst($order->status),
                    '$' . number_format($order->total, 2),
                    $order->orderItems->count(),
                    $books,
                    $order->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ============ REPORTES ============
    
    public function reports(Request $request)
    {
        $period = $request->get('period', '30'); // días
        $startDate = now()->subDays($period);

        // Ventas por categoría
        $salesByCategory = DB::table('order_items')
            ->join('books', 'order_items.book_id', '=', 'books.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->where('orders.created_at', '>=', $startDate)
            ->select('books.category', 
                    DB::raw('COUNT(*) as total_orders'),
                    DB::raw('SUM(order_items.quantity) as total_books'),
                    DB::raw('SUM(order_items.price * order_items.quantity) as revenue'))
            ->groupBy('books.category')
            ->orderBy('revenue', 'desc')
            ->get();

        // Ventas mensuales del año actual
        $monthlySales = Order::where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as orders, SUM(total) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Top libros más vendidos
        $topBooks = DB::table('order_items')
            ->join('books', 'order_items.book_id', '=', 'books.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->where('orders.created_at', '>=', $startDate)
            ->select('books.id', 'books.title', 'books.author', 'books.category', 'books.price',
                    DB::raw('SUM(order_items.quantity) as total_sold'),
                    DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue'))
            ->groupBy('books.id', 'books.title', 'books.author', 'books.category', 'books.price')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        // Estadísticas generales
        $stats = [
            'period_revenue' => Order::where('status', 'completed')
                                   ->where('created_at', '>=', $startDate)
                                   ->sum('total'),
            'period_orders' => Order::where('created_at', '>=', $startDate)->count(),
            'new_users' => User::where('role', 'user')
                              ->where('created_at', '>=', $startDate)
                              ->count(),
            'total_books' => Book::count(),
            'active_users' => User::where('role', 'user')
                                 ->whereHas('orders')
                                 ->count()
        ];

        return view('admin.reports', compact(
            'salesByCategory', 
            'monthlySales', 
            'topBooks', 
            'stats', 
            'period'
        ));
    }

    // Agregar este método al AdminController.php

public function reportsExport(Request $request)
{
    $period = $request->get('period', '30');
    $startDate = now()->subDays($period);

    // Obtener todos los datos
    $salesByCategory = DB::table('order_items')
        ->join('books', 'order_items.book_id', '=', 'books.id')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->where('orders.status', 'completed')
        ->where('orders.created_at', '>=', $startDate)
        ->select('books.category', 
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(order_items.quantity) as total_books'),
                DB::raw('SUM(order_items.price * order_items.quantity) as revenue'))
        ->groupBy('books.category')
        ->orderBy('revenue', 'desc')
        ->get();

    $topBooks = DB::table('order_items')
        ->join('books', 'order_items.book_id', '=', 'books.id')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->where('orders.status', 'completed')
        ->where('orders.created_at', '>=', $startDate)
        ->select('books.title', 'books.author', 'books.category',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue'))
        ->groupBy('books.id', 'books.title', 'books.author', 'books.category')
        ->orderBy('total_sold', 'desc')
        ->get();

    $stats = [
        'period_revenue' => Order::where('status', 'completed')
                               ->where('created_at', '>=', $startDate)
                               ->sum('total'),
        'period_orders' => Order::where('created_at', '>=', $startDate)->count(),
        'new_users' => User::where('role', 'user')
                          ->where('created_at', '>=', $startDate)
                          ->count(),
        'total_books' => Book::count(),
        'active_users' => User::where('role', 'user')
                             ->whereHas('orders')
                             ->count()
    ];

    $filename = 'reporte_' . $period . '_dias_' . now()->format('Y-m-d_H-i-s') . '.csv';
    
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"{$filename}\"",
    ];

    $callback = function() use ($salesByCategory, $topBooks, $stats, $period, $startDate) {
        $file = fopen('php://output', 'w');
        
        // Encabezado del reporte
        fputcsv($file, ['REPORTE DE VENTAS - BIBLIOTECADIGITAL']);
        fputcsv($file, ['Período: ' . $period . ' días']);
        fputcsv($file, ['Desde: ' . $startDate->format('d/m/Y')]);
        fputcsv($file, ['Hasta: ' . now()->format('d/m/Y')]);
        fputcsv($file, ['Generado: ' . now()->format('d/m/Y H:i:s')]);
        fputcsv($file, []);

        // Estadísticas generales
        fputcsv($file, ['ESTADÍSTICAS GENERALES']);
        fputcsv($file, ['Métrica', 'Valor']);
        fputcsv($file, ['Ingresos del período', '$' . number_format($stats['period_revenue'], 2)]);
        fputcsv($file, ['Órdenes del período', $stats['period_orders']]);
        fputcsv($file, ['Nuevos usuarios', $stats['new_users']]);
        fputcsv($file, ['Total de libros', $stats['total_books']]);
        fputcsv($file, ['Usuarios activos', $stats['active_users']]);
        fputcsv($file, ['Valor promedio por orden', '$' . number_format($stats['period_revenue'] / max($stats['period_orders'], 1), 2)]);
        fputcsv($file, []);

        // Ventas por categoría
        fputcsv($file, ['VENTAS POR CATEGORÍA']);
        fputcsv($file, ['Categoría', 'Órdenes', 'Libros Vendidos', 'Ingresos']);
        foreach ($salesByCategory as $category) {
            fputcsv($file, [
                $category->category,
                $category->total_orders,
                $category->total_books,
                '$' . number_format($category->revenue, 2)
            ]);
        }
        fputcsv($file, []);

        // Top libros más vendidos
        fputcsv($file, ['TOP LIBROS MÁS VENDIDOS']);
        fputcsv($file, ['Ranking', 'Título', 'Autor', 'Categoría', 'Unidades Vendidas', 'Ingresos']);
        foreach ($topBooks as $index => $book) {
            fputcsv($file, [
                $index + 1,
                $book->title,
                $book->author,
                $book->category,
                $book->total_sold,
                '$' . number_format($book->total_revenue, 2)
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
    // ============ MÉTODOS AUXILIARES ============
    
    public function getCategories()
    {
        return response()->json(Book::distinct()->pluck('category'));
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'items' => 'required|array'
        ]);

        $action = $request->action;
        $items = $request->items;

        switch ($action) {
            case 'delete':
                Book::whereIn('id', $items)->delete();
                $message = 'Libros eliminados exitosamente';
                break;
            case 'activate':
                Book::whereIn('id', $items)->update(['status' => 'active']);
                $message = 'Libros activados exitosamente';
                break;
            case 'deactivate':
                Book::whereIn('id', $items)->update(['status' => 'inactive']);
                $message = 'Libros desactivados exitosamente';
                break;
        }

        return response()->json(['message' => $message]);
    }
}