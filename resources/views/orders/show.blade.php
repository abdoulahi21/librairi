<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-2xl font-semibold">📦 Détails de la Commande #{{ $order->id }}</h2>
    </x-slot>

    <div class="container mt-5">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="fw-bold">Statut :
                        <span class="badge {{ $order->status == 'en attente' ? 'text-bg-warning' : '' }}
                            {{ $order->status == 'en préparation' ? 'text-bg-primary' : '' }}
                            {{ $order->status == 'expédiée' ? 'text-bg-success' : '' }}
                            {{ $order->status == 'payée' ? 'text-bg-secondary' : '' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </h5>
                    <h5 class="text-primary fw-bold">Total : {{ number_format($order->total_price, 2, ',', ' ') }} €</h5>
                </div>

                <p class="text-muted">Passée le : {{ $order->created_at->format('d/m/Y') }}</p>

                <h6 class="fw-bold mt-3">📚 Livres commandés :</h6>
                <ul class="list-group">
                    @foreach($order->items as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex">
                                @if ($item->book->image)
                                    <img src="{{ asset('storage/' . $item->book->image) }}" alt="{{ $item->book->title }}" width="50" class="me-3 rounded">
                                @else
                                    <img src="https://via.placeholder.com/50" alt="Image par défaut" class="me-3 rounded">
                                @endif
                                <div>
                                    <strong>{{ $item->book->title }}</strong>
                                    <p class="text-muted mb-0">Quantité : {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <span class="fw-bold">{{ number_format($item->quantity * $item->price, 2, ',', ' ') }} Fcfa</span>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-4 text-end">
                    @if($order->status == 'En attente')
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment annuler cette commande ?');">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-danger">❌ Annuler la commande</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">⬅ Retour aux commandes</a>
        </div>
    </div>
</x-app-layout>

