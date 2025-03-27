<x-app-layout>
    <x-slot name="header">
        <h2 class="mb-4 text-center">📚 Boutique en ligne</h2>
        <li class="nav-item float-end">
            <a href="{{ route('cart.index') }}" class="nav-link">
                🛒 <span class="badge bg-danger">{{ session('cart') ? count(session('cart')) : 0 }}</span>
            </a>
        </li>
    </x-slot>

    <div class="container mt-5">

        <!-- Formulaire de filtre -->
        <form method="GET" action="{{ route('books.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="min_price" class="form-label">Prix Min :</label>
                    <input type="number" name="min_price" id="min_price" class="form-control" value="{{ request('min_price') }}">
                </div>
                <div class="col-md-3">
                    <label for="max_price" class="form-label">Prix Max :</label>
                    <input type="number" name="max_price" id="max_price" class="form-control" value="{{ request('max_price') }}">
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">Catégorie :</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">Toutes</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->libelle }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">🔍 Rechercher</button>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <a href="{{ route('books.index') }}" class="btn btn-secondary w-100">🔄 Réinitialiser</a>
                </div>
            </div>
        </form>

        <!-- Affichage des livres en mode e-commerce -->
        <div class="row">
            @forelse ($books as $book)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <a href="{{ route('books.show', $book->id) }}">
                            @if ($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" class="card-img-top" alt="Image du livre">
                            @else
                                <img src="https://via.placeholder.com/200" class="card-img-top" alt="Image par défaut">
                            @endif
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('books.show', $book->id) }}" class="text-dark text-decoration-none">
                                    {{ $book->title }}
                                </a>
                            </h5>
                            <p class="card-text"><strong>Auteur :</strong> {{ $book->author }}</p>
                            <p class="card-text"><strong>Prix :</strong> <span class="text-danger">{{ number_format($book->price, 2) }} Fcfa</span></p>
                            <p class="card-text"><strong>Catégorie :</strong> {{ $book->categorie ? $book->categorie->libelle : 'Aucune' }}</p>

                            <!-- Formulaire d'ajout au panier -->
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <input type="number" name="quantity" value="1" min="1" class="form-control w-25">
                                    <button type="submit" class="btn btn-success">Ajouter au panier
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <div class="alert alert-warning text-center">
                        Aucun livre disponible pour le moment.
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $books->links() }}
        </div>
    </div>
</x-app-layout>
