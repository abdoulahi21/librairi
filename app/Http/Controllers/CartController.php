<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    // Afficher le panier
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Ajouter un livre au panier
    public function add(Request $request)
    {
        $book = Book::findOrFail($request->book_id);
        $cart = session()->get('cart', []);

        // Vérifier si le livre est déjà dans le panier
        if (isset($cart[$book->id])) {
            $cart[$book->id]['quantity'] += $request->quantity;
        } else {
            $cart[$book->id] = [
                'title' => $book->title,
                'price' => $book->price,
                'quantity' => $request->quantity,
                'category' => $book->categorie->libelle,
                'image' => $book->image,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Livre ajouté au panier !');
    }

    // Supprimer un livre du panier
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$request->book_id])) {
            unset($cart[$request->book_id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('success', 'Livre retiré du panier !');
    }

    // Vider le panier
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Panier vidé !');
    }


}
