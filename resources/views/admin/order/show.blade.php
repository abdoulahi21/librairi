<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Détails de la commande #{{ $order->id }}</h2>
    </x-slot>

    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5>🛒 Commande #{{ $order->id }}</h5>
            </div>
            <div class="card-body">
                <h6><strong>Client :</strong> {{ $order->user->name }} ({{ $order->user->email }})</h6>
                <h6><strong>Date de commande :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</h6>
                <h6><strong>Date Payment  :</strong> {{ $order->payment ? $order->payment->paid_at->format('d/m/Y H:i') : 'Non payé' }}</h6>

                <div class="mt-3">
                    <h6><strong>Statut :</strong></h6>
                    @if($order->status == 'en attente' )
                        <a href="{{ route('orders.payée', $order->id) }}" class="badge text-bg-warning">Payer</a
                    @endif
                    @if($order->status == 'payée' )
                        <a href="{{ route('orders.preparation', $order->id) }}" class="badge text-bg-secondary">En préparation</a
                    @endif
                    @if($order->status == 'en préparation' )
                        <a href="{{ route('orders.expedie', $order->id) }}" class="badge text-bg-success">Expédier</a
                    @endif
                    @if($order->status == 'expédiée' )
                        <span class="badge text-bg-success">Terminé</span>
                    @endif
                </div>

                <div class="mt-4">
                    <h6><strong>Livres commandés :</strong></h6>
                    <table class="table table-bordered">
                        <thead class="table-light">
                        <tr>
                            <th>Livre</th>
                            <th>quantité</th>
                            <th>Prix Unitaire</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->book->title }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 2) }} Fcfa</td>
                                <td><strong>{{ number_format($item->quantity * $item->price, 2) }} Fcfa</strong></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <h5><strong>Total :</strong> <span class="text-success">{{ number_format($order->total_price, 2) }} Fcfa</span></h5>
                </div>

                <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">⬅️ Retour à la liste des commandes</a>
            </div>
        </div>
    </div>
</x-app-layout>

