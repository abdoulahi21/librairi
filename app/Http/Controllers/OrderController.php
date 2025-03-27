<?php

namespace App\Http\Controllers;

use App\Mail\OrderShipped;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if(!auth()->check() || auth()->user()->role !== 'client'){
            $orders = Order::orderBy('created_at', 'desc')->paginate(10);
            return view('admin.order.index', compact('orders'));
        }else{
            $orders = Order::orderBy('created_at', 'desc')->paginate(10);
            return view('orders.index', compact('orders'));
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        // Créer la commande
        $orders = Order::create([
            'user_id' => auth()->id(),
            'total_price' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            //'status' => 'En attente',
        ]);

        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $orders->id,
                'book_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        session()->forget('cart');
        return redirect()->route('orders.index',compact('orders'))->with('success', 'Commande passée avec succès !');
    }

    public function payée(string $orderId)
    {
        $orders = Order::find($orderId);
        // Mettre à jour le statut de la commande
        $orders->status ='payée';
        $orders->save();
        return redirect()->route('orders.index',$orders)->with('success', 'Statut mis à jour avec succès.');
    }

    public function preparation(string $orderId)
    {
        $orders = Order::find($orderId);
        // Mettre à jour le statut de la commande
        $orders->status ='en préparation';
        $orders->save();
        return redirect()->route('orders.index',$orders)->with('success', 'Statut mis à jour avec succès.');
    }
    public function expedie(string $orderId)
    {
        $orders = Order::find($orderId);
        // Mettre à jour le statut de la commande
        $orders->status ='expédiée';
        $orders->save();

        Mail::to($orders->user->email)->send(new OrderShipped($orders));

        return redirect()->route('orders.index',$orders)->with('success', 'Statut mis à jour avec succès.');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'books' => 'required|array',
            'books.*.id' => 'exists:books,id',
            'books.*.quantity' => 'required|integer|min:1'
        ]);

        $user = auth()->user();

        // Création de la commande
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => 0, // On calculera le total après
        ]);

        $total = 0;

        // Ajout des livres commandés
        foreach ($request->books as $item) {
            $book = Book::findOrFail($item['id']);
            $subtotal = $book->price * $item['quantity'];
            $total += $subtotal;

            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $book->id,
                'quantity' => $item['quantity'],
                'price' => $book->price
            ]);
        }

        // Mise à jour du total de la commande
        $order->update(['total_price' => $total]);

        return redirect()->route('book.show', $order->id)->with('success', 'Commande passée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
        if(!auth()->check() || auth()->user()->role !== 'client'){
            return view('admin.order.show', compact('order'));
        }else{

            return view('orders.show', compact('order'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
