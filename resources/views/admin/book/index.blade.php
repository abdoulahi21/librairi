<x-app-layout>
    <x-slot name="header">
        <h2 class="mb-4 text-center">📚 Liste des Livres</h2>
        @can('manage-book')
            <a href="{{route('books.create')}}" class="btn btn-outline-primary" >Ajouter un nouveau livre</a>
        @endcan
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
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category->libelle}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="author" class="form-label">Auteur :</label>
                    <input type="text" name="author" id="author" class="form-control" value="{{ request('author') }}">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">🔍 Rechercher</button>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <a href="{{ route('books.index') }}" class="btn btn-secondary w-100">🔄 Réinitialiser</a>
                </div>
            </div>
        </form>

        <!-- Tableau des livres -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Prix (Fcfa)</th>
                    <th>Stock</th>
                    <th>Catégorie</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($books as $book)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" alt="Image du livre" width="50">
                            @else
                                <span class="text-muted">Aucune image</span>
                            @endif
                        </td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ number_format($book->price, 2) }} Fcfa</td>
                        <td>{{ $book->stock }}</td>
                        <td>{{ $book->categorie ? $book->categorie->libelle : 'Aucune catégorie' }}</td>
                        <td>
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                            <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-secondary">Details</a>
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer ce livre ?');">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Aucun livre trouvé.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $books->links() }}
        </div>
    </div>
</x-app-layout>
