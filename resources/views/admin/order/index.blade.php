<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-2xl font-semibold">📦 Gestion des Commandes</h2>
    </x-slot>

    <div class="container mt-5">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td class="fw-bold text-primary">{{ number_format($order->total_price, 2, ',', ' ') }} €</td>
                        <td>
                            @if($order->status == 'en attente' )
                                <a href="{{ route('orders.payée', $order->id) }}" class="badge text-bg-warning">En attente de payement</a
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
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.order.show', ['order' => $order->id]) }}" class="btn btn-sm btn-info">Voir détails</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Aucune commande trouvée.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>

