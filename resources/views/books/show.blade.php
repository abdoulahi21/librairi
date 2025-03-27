<x-app-layout>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Détails du Livre</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Image du livre -->
                    <div class="col-md-4">
                        <img src="{{ asset('storage/' . $book->image) }}" class="img-fluid rounded shadow" alt="Image du livre">
                    </div>

                    <!-- Détails du livre -->
                    <div class="col-md-8">
                        <h3>{{ $book->title }}</h3>
                        <p><strong>Auteur :</strong> {{ $book->author }}</p>
                        <p><strong>Prix :</strong> {{ number_format($book->price, 2, ',', ' ') }} €</p>
                        <p><strong>Stock :</strong> {{ $book->stock }}</p>
                        <p><strong>Catégorie :</strong> {{ $book->categorie->libelle ?? 'Non défini' }}</p>
                        <p><strong>Description :</strong> {{ $book->description ?? 'Aucune description disponible' }}</p>

                        <!-- Boutons -->
                        <div class="mt-3">
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning">Modifier</a>
                            <a href="{{ route('books.index') }}" class="btn btn-secondary">Retour</a>

                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer ce livre ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
