<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-2xl font-semibold">🛍️ Mes Commandes</h2>
    </x-slot>

    <div class="container mt-5">
        @if($orders->isEmpty())
            <div class="alert alert-info text-center">
                📦 Vous n'avez encore passé aucune commande.
            </div>
        @else
            @foreach($orders as $order)
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold">Commande #{{ $order->id }}</h5>
                            @php
                                $statusClasses = [
                                    'en attente' => 'bg-warning',
                                    'payée' => 'bg-success',
                                    'expédiée' => 'bg-primary',
                                    'en préparation' => 'bg-info',
                                    'Annulée' => 'bg-danger'
                                ];
                            @endphp

                            <span class="badge {{ $statusClasses[$order->status] ?? 'bg-warning' }}">
                           {{ $order->status }}
                            </span>
                        </div>

                        <p class="text-muted">Passée le : {{ $order->created_at->format('d/m/Y') }}</p>

                        <div class="mt-3">
                            <h6 class="fw-bold">📚 Livres commandés :</h6>
                            <ul class="list-group">
                                @foreach ($order->items as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $item->book->title }}</strong>
                                            <span class="text-muted">({{ $item->quantity }} x {{ number_format($item->price, 2, ',', ' ') }} Fcfa)</span>
                                        </div>
                                        <span class="fw-bold">{{ number_format($item->quantity * $item->price, 2, ',', ' ') }} Fcfa</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <h5 class="text-primary fw-bold">Total : {{ number_format($order->total_price, 2, ',', ' ') }} Fcfa</h5>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary">🛒 Voir détails</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</x-app-layout>
