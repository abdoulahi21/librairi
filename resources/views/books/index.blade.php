<x-app-layout>
    <x-slot name="header">
        <h2 class="mb-4 text-center">📚 Boutique en ligne</h2>
    </x-slot>

    <div class="container mt-4">

        <!-- 🔔 Messages d'alerte -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- 🏷️ Formulaire de filtre -->
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

        <!-- 📚 Affichage des livres -->
        <div class="row">
            @forelse ($books as $book)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4 position-relative">
                        <!-- Affichage de l'image -->
                        <a href="{{ route('books.show', $book->id) }}">
                            <img src="{{ $book->image ? asset('storage/' . $book->image) : 'https://via.placeholder.com/200' }}"
                                 class="card-img-top rounded-top-4 w-100"
                                 style="height: 180px; object-fit: cover;"
                                 alt="Image du livre">
                        </a>

                        <!-- Étiquette de réduction -->
                        @if($book->old_price && $book->old_price > $book->price)
                            <span class="position-absolute top-0 end-0 bg-warning text-white px-2 py-1 rounded-start">
                -{{ round((($book->old_price - $book->price) / $book->old_price) * 100) }}%
            </span>
                        @endif

                        <div class="card-body">
                            <h6 class="card-title text-truncate">
                                <a href="{{ route('books.show', $book->id) }}" class="text-dark text-decoration-none">
                                    {{ $book->title }}
                                </a>
                            </h6>

                            <p class="card-text small text-muted">Auteur : {{ $book->author }}</p>

                            <!-- Prix avec ancien prix barré -->
                            <p class="mb-2">
                                <strong class="text-danger fs-5">{{ number_format($book->price, 2) }} FCFA</strong>
                                @if($book->old_price && $book->old_price > $book->price)
                                    <small class="text-muted text-decoration-line-through">{{ number_format($book->old_price, 2) }} FCFA</small>
                                @endif
                            </p>

                            <!-- Barre de stock -->
                            <div class="mb-2">
                                <small>{{ $book->stock }} articles restants</small>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar {{ $book->stock > 10 ? 'bg-success' : ($book->stock > 3 ? 'bg-warning' : 'bg-danger') }}"
                                         role="progressbar"
                                         style="width: {{ min(100, ($book->stock / 50) * 100) }}%;"
                                         aria-valuenow="{{ $book->stock }}"
                                         aria-valuemin="0"
                                         aria-valuemax="50">
                                    </div>
                                </div>
                            </div>

                            <!-- Bouton Ajouter au panier -->
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $book->stock }}" class="form-control w-25">
                                    <button type="submit" class="btn btn-success btn-sm {{ $book->stock > 0 ? '' : 'disabled' }}">
                                        Ajouter 🛒
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

        <!-- 📌 Pagination stylisée -->
        <div class="d-flex justify-content-center mt-4">
            <nav>
                <ul class="pagination">
                    {{ $books->links() }}
                </ul>
            </nav>
        </div>
    </div>
</x-app-layout>
