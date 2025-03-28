<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Categorie;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'client') {


            $query = Book::query();

            // Filtrer par prix minimum
            if ($request->filled('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }

            // Filtrer par prix maximum
            if ($request->filled('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }

            // Filtrer par catégorie
            if ($request->filled('category_id')) {
                $query->where('libelle', $request->category);
            }

            // Filtrer par auteur
            if ($request->filled('author')) {
                $query->where('author', 'like', "%{$request->author}%");
            }

            $books = $query->paginate(10); // Ajout de la pagination

            // Récupérer toutes les catégories pour le filtre
            $categories = Categorie::all();

            return view('admin.book.index', compact('books', 'categories'));
        }else {

            $query = Book::where('status', 'desarchiver');

            // Filtrer par prix minimum
            if ($request->filled('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }

            // Filtrer par prix maximum
            if ($request->filled('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }

            // Filtrer par catégorie
            if ($request->filled('category_id')) {
                $query->where('libelle', $request->category);
            }

            // Filtrer par auteur
            if ($request->filled('author')) {
                $query->where('author', 'like', "%{$request->author}%");
            }

            $books = $query->paginate(10); // Ajout de la pagination

            // Récupérer toutes les catégories pour le filtre
            $categories = Categorie::all();

            return view('books.index', compact('books', 'categories'));
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Categorie::all();
        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Gérer l'upload de l'image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
        }

       $books= Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('books.index',$books)->with('success', 'Livre ajouté avec succès.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $categories = Categorie::all();
        return view('books.edit', compact('book','categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($book->image) {
                Storage::delete('public/' . $book->image);
            }
            $imagePath = $request->file('image')->store('books', 'public');
        } else {
            $imagePath = $book->image;
        }

        // Mise à jour du livre
        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('books.index')->with('success', 'Livre mis à jour avec succès.');
    }

    public function archiver(string $orderId)
    {
        $books = Book::find($orderId);
        // Mettre à jour le statut de la commande
        $books->status ='archiver';
        $books->save();
        return redirect()->route('books.index',$books)->with('success', 'Statut mis à jour avec succès.');
    }
    public function desarchiver(string $orderId)
    {
        $books = Book::find($orderId);
        // Mettre à jour le statut de la commande
        $books->status ='desarchiver';
        $books->save();
        return redirect()->route('books.index',$books)->with('success', 'Statut mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Book::find($id)->delete();
        return redirect()->route('books.index');
    }
}
