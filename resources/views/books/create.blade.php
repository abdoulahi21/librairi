<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Page ajout Livres
        </h2>
    </x-slot>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0 text-center">Ajouter un Livre</h4>
                    </div>
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <!-- Colonne gauche -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Titre :</label>
                                        <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="author" class="form-label">Auteur :</label>
                                        <input type="text" name="author" id="author" class="form-control" required value="{{ old('author') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="price" class="form-label">Prix (€) :</label>
                                        <input type="number" step="0.01" name="price" id="price" class="form-control" required value="{{ old('price') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="stock" class="form-label">Stock disponible :</label>
                                        <input type="number" name="stock" id="stock" class="form-control" required value="{{ old('stock', 0) }}">
                                    </div>
                                </div>

                                <!-- Colonne droite -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Catégorie :</label>
                                        <select name="category_id" id="category" class="form-select">
                                            <option value="">Choisir</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description :</label>
                                        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image du Livre :</label>
                                        <input type="file" name="image" id="image" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-outline-success">Enregistrer</button>
                            <button type="reset" class="btn btn-outline-danger">Annuler</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
