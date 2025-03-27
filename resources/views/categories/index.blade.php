<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Categories') }}
        </div>
        </h2>  <a href="{{route('categories.create')}}" class="btn btn-primary">Ajouter un catègories</a>
    </x-slot>
    <div class="container mt-5 col-md-5">
        <div class="card">
            <div class="card-header">
                <h3>Listes des categories</h3>
            </div>
            <div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Libelle</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->libelle }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>




