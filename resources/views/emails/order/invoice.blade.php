<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture Commande #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 10px 10px 0 0;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 0 0 10px 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>📜 Facture #{{ $order->id }}</h2>
</div>

<div class="content">
    <p><strong>Date:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
    <p><strong>Client:</strong> {{ $order->user->name }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

    <table>
        <thead>
        <tr>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Prix</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->items as $item)
            <tr>
                <td>{{ $item->book->title }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2, ',', ' ') }} €</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p class="total">Total : {{ number_format($order->total_price, 2, ',', ' ') }} €</p>
</div>

<div class="footer">
    Merci pour votre commande ! 😊<br>
    Boutique en ligne - www.maboutique.com
</div>

</body>
</html>
