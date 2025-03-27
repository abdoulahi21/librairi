<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🛒 Mon Panier
        </h2>
    </x-slot>
    <div class="container mt-5">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(empty($cart))
            <div class="alert alert-info">Votre panier est vide.</div>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>Livre</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php $total += $item['price'] * $item['quantity']; @endphp
                    <tr>
                        <td><img src="{{ asset('storage/' . $item['image']) }}" width="50"></td>
                        <td>{{ $item['title'] }}</td>
                        <td>{{ $item['category'] }}</td>
                        <td>{{ $item['price'] }} €</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ number_format($item['price'] * $item['quantity'], 2) }} €</td>
                        <td>
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $id }}">
                                <button type="submit" class="btn btn-danger btn-sm">Retirer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5"><strong>Total :</strong></td>
                    <td><strong>{{ number_format($total, 2) }} €</strong></td>
                    <td></td>
                </tr>
                </tbody>
            </table>

            <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-warning">Vider le panier</button>
            </form>

            <a href="{{ route('orders.create') }}" class="btn btn-outline-success">Passer la commande</a>
                <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Continuer L'achat</a>
        @endif
    </div>
</x-app-layout>
