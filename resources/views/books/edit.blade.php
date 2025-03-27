<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier un Livre
        </h2>
    </x-slot>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                <div class="card shadow-lg">
                    <div class="card-header ">

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

                        <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label">Titre :</label>
                                    <input type="text" name="title" id="title" class="form-control" required value="{{ old('title', $book->title) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="author" class="form-label">Auteur :</label>
                                    <input type="text" name="author" id="author" class="form-control" required value="{{ old('author', $book->author) }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label">Prix (€) :</label>
                                    <input type="number" step="0.01" name="price" id="price" class="form-control" required value="{{ old('price', $book->price) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="stock" class="form-label">Stock disponible :</label>
                                    <input type="number" name="stock" id="stock" class="form-control" required value="{{ old('stock', $book->stock) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Catégorie :</label>
                                <select name="category_id" id="category_id" class="form-select">
                                    <option value="">Choisir une catégorie</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $book->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                            {{ $category->libelle }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="description" class="form-label">Description :</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description', $book->description) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image du Livre :</label>
                                <input type="file" name="image" id="image" class="form-control">
                                @if ($book->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $book->image) }}" alt="Image du livre" width="100">
                                    </div>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-outline-success">Mettre à jour</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
