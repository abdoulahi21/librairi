<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center">📊 Tableau de Bord Administratif</h2>
    </x-slot>

    <div class="container mt-4">
        <div class="row">

            <!-- Statistiques générales -->
            <div class="col-md-4">
                <div class="card shadow-sm bg-warning text-white">
                    <div class="card-body">
                        <h5>📦 Commandes en cours</h5>
                        <h2>{{ $pendingOrders }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm bg-success text-white">
                    <div class="card-body">
                        <h5>✅ Commandes validées</h5>
                        <h2>{{ $validatedOrders }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm bg-primary text-white">
                    <div class="card-body">
                        <h5>💰 Recettes journalières</h5>
                        <h2>{{ number_format($dailyRevenue, 2, ',', ' ') }} Fcfa</h2>
                    </div>
                </div>
            </div>

        </div>

        <!-- Graphiques -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">📈 Commandes par mois</h5>
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">📊 Livres vendus par catégorie</h5>
                        <canvas id="booksChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts pour Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Graphique des commandes par mois
        var ordersChart = new Chart(document.getElementById('ordersChart'), {
            type: 'bar',
            data: {
                labels: @json($ordersByMonth->pluck('month')),
                datasets: [{
                    label: 'Nombre de commandes',
                    data: @json($ordersByMonth->pluck('count')),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                }]
            }
        });

        // Graphique des livres vendus par catégorie
        var booksChart = new Chart(document.getElementById('booksChart'), {
            type: 'bar',
            data: {
                labels: @json($booksByCategory->pluck('category_id')), // Remplace par les noms des catégories si besoin
                datasets: [{
                    label: 'Livres vendus',
                    data: @json($booksByCategory->pluck('total')),
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                }]
            }
        });
    </script>
</x-app-layout>

