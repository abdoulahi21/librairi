<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    //
    public function dashboard()
    {
        // Date du jour
        $today = Carbon::today();


        // Commandes en cours aujourd'hui (statut != "Expédiée")
        $pendingOrders = Order::whereDate('created_at', $today)
            ->where('status', '!=', 'expédiée')
            ->count();

        $validatedOrders = Order::whereHas('payment', function ($query) use ($today) {
            $query->whereDate('paid_at', $today);
        })
            ->count();

        // dd($validatedOrders);
        // Recettes journalières (total des paiements reçus aujourd'hui)
        $dailyRevenue = Order::whereHas('payment', function ($query) use ($today) {
            $query->whereDate('paid_at', $today);
        })
            ->sum('total_price');

        // Nombre de commandes par mois (pour Chart.js)
        $ordersByMonth = Order::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count')
            ->groupByRaw('EXTRACT(MONTH FROM created_at)')
            ->orderByRaw('EXTRACT(MONTH FROM created_at)')
            ->get();


        // Nombre de livres vendus par catégorie par mois
        $booksByCategory = Book::join('order_items', 'books.id', '=', 'order_items.book_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'Payée')
            ->selectRaw('books.category_id, EXTRACT(MONTH FROM orders.created_at) as month, SUM(order_items.quantity) as total')
            ->groupByRaw('books.category_id, EXTRACT(MONTH FROM orders.created_at)')
            ->orderByRaw('EXTRACT(MONTH FROM orders.created_at)')
            ->get();


        return view('admin.dashboard', compact(
            'pendingOrders',
            'validatedOrders',
            'dailyRevenue',
            'ordersByMonth',
            'booksByCategory',
            'today'
        ));
    }
}
